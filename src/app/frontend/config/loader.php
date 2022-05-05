<?php
use Phalcon\Loader;

$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
        BASE_PATH.'/vendor/',
      
       
    ]
);
$loader->registerNamespaces(
    [
        'App\Handler' => APP_PATH . '/handler/'
        
    ]
);
$loader->registerNamespaces(
    [
        'App\Component' => APP_PATH . '/component/'
        
    ]
);

$loader->register();