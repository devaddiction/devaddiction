<?php

return array(

    /**
     * Storage path for file based repositories such as
     * JsonStaticRepository.
     */
    'storage' => base_path() . '/content',

    /**
     * Cache Lifetime: 1 day
     */
    'cache_ttl' => 1440,

    /**
     * Classes to use for the Automatic resolution of the IoC
     * on App::make('articler')
     */
    'repository' => function($app) {
        return new Kazan\Articler\Repository\JsonStaticRepository(
            new Kazan\Articler\Filesystem\LaravelFilesystem(),
            $app['config']->get('articler::storage')
        );
    },

    'parser' => function($app) {
        return new Kazan\Articler\Parser\MarkdownParser();
    },

    'cache' => function($app) {
        return new Kazan\Articler\Cache\LaravelCache();
    },

    'configurator' => function($app) {
        return new Kazan\Articler\Config\LaravelConfig();
    },

);
