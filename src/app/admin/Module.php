<?php

namespace Multi\Admin;

use Phalcon\Loader;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
use Phalcon\Url;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;


class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $container = null)
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            [
                'Multi\Admin\Controllers' => APP_PATH.'/admin/controllers/',
                'Multi\Admin\Models'      => APP_PATH.'/admin/models/',
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
                    'Multi\Admin\Controllers'
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
                    '../app/admin/views/'
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
        $container->setShared('session', function () {
            $session = new SessionManager();
            $files = new SessionAdapter([
                'savePath' => sys_get_temp_dir(),
            ]);
            $session->setAdapter($files);
            $session->start();
        
            return $session;
        });
        $container->set('mongo',function(){
            $mongo = new \MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@cluster0.bromc.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
            return $mongo;
            
            },true);
         $container->set(
                'logger',
                function () {
            
                    $adapter1  = new Stream(APP_PATH.'/logs/login.log');
                    $adapter2  = new Stream(APP_PATH.'/logs/signup.log');
                    $logger  = new Logger(
                        'messages',
                        [
                            'login' => $adapter1,
                            'signup' => $adapter2,
                        ]
                    );
                    return $logger;
                }
            );
    }
}