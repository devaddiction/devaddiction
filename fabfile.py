from __future__ import with_statement
from fabric.api import *
import time
import datetime

#configure this
publish_dirs = {'staging': 'test.devaddiction.com', 'production': 'devaddiction.com'}
env.hosts = ['fjalvarez@devaddiction.com']
srv_root = '/var/www/'
repo = 'git@github.com:devaddiction/devaddiction.git'

timestamp = datetime.datetime.fromtimestamp(int(time.time())).strftime('%Y%m%d-%H%M%S')
timestamped = "release-%s" % timestamp


#
# Deploy TASKS
#
def production():
    deploy(version='production', branch='stable')


def stage():
    current_branch = local('git rev-parse --abbrev-ref HEAD', capture=True)
    local('git push linode %s' % current_branch)
    deploy(version='staging', branch=current_branch)


def deploy(version='staging', branch='master'):
    publish_dir = "%s%s" % (srv_root, publish_dirs[version])
    current_release_path = "%s/releases/%s" % (publish_dir, timestamped)
    fetch_repo(branch, publish_dir)
    run_composer(current_release_path)
    cleanup_clone(publish_dir, current_release_path)
    build_site(current_release_path)
    update_permissions(current_release_path)
    update_robots(current_release_path, version)
    update_symlinks(publish_dir, current_release_path)


def rollback(option='list', version='staging'):
    publish_dir = "%s%s" % (srv_root, publish_dirs[version])

    if option == 'list':
        with cd("%s/releases" % publish_dir):
            run("ls -d *")
    else:
        release_path = "%s/releases/%s" % (publish_dir, option)
        update_symlinks(publish_dir, release_path)


#
# Helper Tasks
#
def fetch_repo(branch, publish_dir):
    with cd(publish_dir):
        with settings(warn_only=True):
            run("mkdir releases")
    with cd("%s/releases" % publish_dir):
        run("git clone %s -b %s %s" % (repo, branch, timestamped))


def run_composer(current_release_path):
    with cd("%s/site" % (current_release_path)):
        run("curl -sS https://getcomposer.org/installer | php")
        run("php composer.phar install")


def cleanup_clone(publish_dir, current_release_path):
    with cd("%s/releases" % publish_dir):
        run("rm -rf %s/.git" % (current_release_path))
        run("rm %s/site/.gitignore" % (current_release_path))


def build_site(current_release_path):
    with cd("%s/site" % (current_release_path)):
        run("php artisan optimize")
        run("php artisan basset:build --production")


def update_permissions(current_release_path):
    with cd("%s" % (current_release_path)):
        run("chmod 777 -R site/app/storage")
        run("chmod 777 -R site/public/assets")


def update_robots(current_release_path, version):
    with cd("%s/site/public" % (current_release_path)):
        run("cp robots.%s.txt robots.txt" % (version))


def update_symlinks(publish_dir, release_path):
    with cd(publish_dir):
        with settings(warn_only=True):
            run("cat last_release > prev_release")
        run("echo '%s' > last_release" % release_path)
        run("ln -nfs %s/site/public public" % (release_path))
