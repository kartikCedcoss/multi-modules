<?php
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;




define('BASE_PATH', dirname(__DIR__));

define('APP_PATH', BASE_PATH . '/app');


 require BASE_PATH . '/vendor/autoload.php';
  


$container = new FactoryDefault();

$loader = new Loader();

$loader->registerNamespaces(
    [
        'App\Component' => APP_PATH . '/component/'
        
    ]
);


$loader->register();
$loader->registerDirs([__DIR__ . '/../app/library/', APP_PATH . '/component/',])->register();

$container->set(
    'router',
    function () {
        $router = new Router();

        $router->setDefaultModule('frontend');

        $router->add(
            '/login',
            [
                'module'     => 'admin',
                'controller' => 'login',
                'action'     => 'index',
            ]
        );
        $router->add(
            '/login/:action',
            [
                'module'     => 'admin',
                'controller' => 'login',
                'action'     => 1,
            ]
        );
        
        $router->add(
            '/product',
            [   'module' => 'admin',
                'controller' => 'product',
                'action'     => 'index',
            ]
        );

        $router->add(
            '/product/:action',
            [   'module' => 'admin',
                'controller' => 'product',
                'action'     => 1,
            ]
        );
       
        $router->add(
            '/order',
            [   'module' => 'admin',
                'controller' => 'order',
                'action'     => 'index',
            ]
        );
        $router->add(
            '/order/:action',
            [   'module' => 'admin',
                'controller' => 'order',
                'action'     => 1,
            ]
        );
        $router->add(
            '/index',
            [   'module' => 'admin',
                'controller' => 'index',
                'action'     => 'index',
            ]
        );

        return $router;
    }
);


$application=new Application($container);
$eventsManager=new EventsManager();

$view = new View();
$application->registerModules(
    [
        'admin' => [
            'className' => \Multi\admin\Module::class,
            'path'      => APP_PATH.'/admin/Module.php'
        ],
        'frontend'  => [
            'className' => \Multi\Front\Module::class,
            'path'      => APP_PATH.'/frontend/Module.php'
        ]
    ]
);

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'EventsManager',
    $eventsManager
);

$application->setEventsManager($eventsManager);
try {
    
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
