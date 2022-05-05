<?php

namespace Multi\Front;

use Phalcon\Loader;
use Phalcon\Url;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $container = null)
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            [
                'Multi\Front\Controllers' => APP_PATH.'/frontend/controllers/',
                'Multi\Front\Models'      => APP_PATH.'/frontend/models/',
            ]
        );

        $loader->register();
    }

    public function registerServices(DiInterface $container)
    {
        // Registering a dispatcher
        $container->set(
            'dispatcher',
            function () {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace(
                    'Multi\Front\Controllers'
                );

                return $dispatcher;
            }
        );

        // Registering the view component
        $container->set(
            'view',
            function () {
                $view = new View();
                $view->setViewsDir(
                    '../app/frontend/views/'
                );
                return $view;
            }
        );
        $container->set(
            'url',
            function () {
                $url = new Url();
                $url->setBaseUri('/');
                return $url;
            }
        );
        $container->set('mongo',function(){
             $mongo = new \MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@cluster0.bromc.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
             return $mongo;
             
             },true);
    }
}