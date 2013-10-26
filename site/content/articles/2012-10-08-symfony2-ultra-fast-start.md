NOTE: This tutorial was made in OpenSuse 12.1, there is no evidence it works on other operating systems. This is just a kind of chop for example if you forget something after reading the Symfony2 documentation, but obviously it is imperative to read it before you know what this is <a href="http://symfony.com/doc/2.0/book/index.html" target="_blank">http://symfony.com/doc/2.0/book/index.html</a>

The source code used is available at: https://github.com/devaddiction/s2_ultra_fast

<h2>1. Download</h2>
Download Symfony2 Standard Edition (at the moment of writing this, last version is 2.0.16): <a href="http://symfony.com/download" title="http://symfony.com/download" target="_blank">http://symfony.com/download</a>

Unzip

<code>tar -zxvf Symfony_Standard_Vendors_2.0.16.tgz</code>

And change the permissions of app/cache and app/logs to be writable by php, for example:

<code>chmod 777 app/cache app/logs</code>

Set the directory on your server "web/" as root and you should be able to load the home page of symfony2 from http://127.0.0.1/app_dev.php/

<h2>2. Configure the database</h2>

Set app/config/parameters.ini with the options of your database (you can also do from <a href="http://127.0.0.1/app_dev.php/_configurator/" target="_blank">http://127.0.0.1/app_dev.php/_configurator/</a>) for mysql would be something like:

<pre class="prettyprint">
[parameters]
    database_driver=pdo_mysql
    database_host=localhost
    database_name=symfony2
    database_user=symfony2
    database_password=password
    mailer_transport=smtp
    mailer_host=localhost
    mailer_user=
    mailer_password=
    locale=en
    csrf_secret=op234j234j2424jojpfwesdcsdc
</pre>

<h2>3. Creating our first bundle</h2>

Now we can create a bundle:

<code>php app/console init:bundle "Alvarez\DevAddictionBundle" src</code>

Now it add to app/autoload.php:

<pre class="prettyprint">
$loader->registerNamespaces(array(
    'Alvarez'  => __DIR__.'/../src',
    // ...
));
</pre>

and add to app/AppKernel.php:

<pre class="prettyprint">
$bundles = array(
    // ...
    new Alvarez\DevAddictionBundle\AlvarezDevAddictionBundleBundle(),
);
</pre>

<h2>4. Path</h2>

For Symfony2 knows where to send the requests, add to app/config/routing_dev.yml:

<pre class="prettyprint">
homepage:
    pattern: /devAddiction
    defaults: { _controller: AlvarezDevAddictionBundle:Default:index }
</pre>

At this point we can load our newly created bundle going to: http://127.0.0.1/app_dev.php/devAddiction

<h2>5. Controller</h2>

The default controller (<em>Alvarez/DevAddictionBundle/Controller/DefaultController.php</em>) has been created by Symfony2. Now let's create the controller StoreController.php

<pre class="prettyprint">
//Alvarez/DevAddictionBundle/Controller/StoreController.php
&lt;?php

namespace Alvarez\DevAddictionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StoreController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction($store)
    {
        return array('store' => $store);
    }
}
</pre>

and add it to app/config/routing_dev.yml

<pre class="prettyprint">
store:
    pattern: /devAddiction/{store}
    defaults: { _controller: AlvarezDevAddictionBundle:Store:store }
</pre>

and a new twig template Alvarez/DevAddictionBundle/Resources/Views/Store/index.html.twig

<pre class="prettyprint">So you want store "{{ store }}"?</pre>

And now loading http://127.0.0.1/app_dev.php/devAddiction/my-shop get:

<code>So you want store "{{ store }}"?</code>

<h2>6. Model</h2>

Starting with Doctrine, let's define our model for a store. First of all, as we have not created any model we have to create the directory Alvarez/DevAddictionBundle/Entity that is where everyone will keep.

And we can begin to Store model:

<pre class="prettyprint">
&lt;?php
// Alvarez/DevAddictionBundle/Entity/Store.php

namespace Alvarez\DevAddictionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Store
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(name="stores_categories",
     *      joinColumns={@ORM\JoinColumn(name="store_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")})
     */
    protected $categories;

    /**
     * @ORM\Column(type="string", length="255")
     */
    protected $url;

    /**
     * @ORM\Column(type="string", length="255")
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $clicks = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $validated = false;

    /**
     * @ORM\Column(type="integer")
     */
    protected $pcomments = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $ncomments = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active = false;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }
}
</pre>

Model Category:

<pre class="prettyprint">
&lt;?php
// Alvarez/DevAddictionBundle/Entity/Category.php

namespace Alvarez\DevAddictionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * @ORM\Column(nullable="true")
     */
    protected $parent;

    /**
     * @ORM\ManyToMany(targetEntity="Store", mappedBy="categories")
     */
    protected $stores;

    /**
     * @ORM\Column(type="string", length="255")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length="255", name="url_string", unique="true")
     */
    protected $urlString;

    public function __construct()
    {
        $this->stores = new \Doctrine\Commmon\Collections\ArrayCollection();
    }
}
</pre>

And now to console and to generate the tables in the database by running:

<code>php app/console doctrine: schema: create</code>

and to complete our model with its getters/setters:

<code>php app/console doctrine: generate: Entities AlvarezDevAddictionundle</code>

<h2>7. Testing the model</h2>

Let's change the action it displays the store to its own action (storeAction) to make room for the index controller in indexAction store, which now displays the total number of stores we have stored in the database.

<pre class="prettyprint">
# app/config/routing_dev.yml
store:
    pattern: /devAddiction/{store}
    defaults: { _controller: AlvarezDevAddictionBundle:Store:store }

store_index:
    pattern: /devAddiction/
    defaults: { _controller: AlvarezDevAddictionBundle:Store:index }
</pre>

<pre class="prettyprint">
&lt;?php
// Alvarez/DevAddictionBundle/Controller/StoreController.php

namespace Alvarez\DevAddictionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StoreController extends Controller
{

    /**
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $stores = $em->createQuery('SELECT count(s.id) AS total FROM Alvarez\DevAddictionBundle\Entity\Store s')->getSingleScalarResult();
        return array('stores' => $stores);
    }

    /**
     * @Template()
     */
    public function storeAction($store)
    {
        return array('store' => $store);
    }
}
</pre>

<pre class="prettyprint">
&lt;!-- Alvarez/DevAddictionBundle/Resources/views/Store/index.html.twig --&gt;
We have a total of {{ stores }} stores.
</pre>

<pre class="prettyprint">
&lt;!-- Alvarez/DevAddictionBundle/Resources/views/Store/store.html.twig --&gt;
So you want store "{{ store }}"?
</pre>

Now we will http://127.0.0.1/app_dev.php/devAddiction/ loads <em>We have a total of 0 stores</em> and loading http://127.0.0.1/app_dev.php/devAddiction/my-shop <em>So you leave us want store "my-shop"?</em>


