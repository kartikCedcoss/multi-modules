<?php


use Phalcon\Mvc\View;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Escaper;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Storage\SerializerFactory;
use Phalcon\Cache\Adapter\Stream;



$container->set('cache',function(){
$serializerFactory = new SerializerFactory();
$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
    'storageDir'        => APP_PATH.'security/',
];

$cache = new Stream($serializerFactory, $options);
return $cache;
});






$container->set('locale', function(){
    return (new \App\Component\Locale())->getTranslator();
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

$container->setShared('db', function () {
    $database = $this->getConfig();
    return new Mysql(
        [
            'host'     => $database->database->host,
            'username' =>  $database->database->username,
            'password' => $database->database->password,
            'dbname'   => $database->database->dbname,
        ]
    );
});







$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$container->set(
    'config',
    function () {

        $fileName = "../app/config/config.php";
        // $factory= new ConfigFactory();
        // return $factory->newInstance("php",$fileName);
        $config = new Config([]);
        $array = new \Phalcon\Config\Adapter\Php($fileName);
        $config->merge($array);
        return $config;
    }
);




$container->set(
    'escaper',
    function () {
        return new Escaper();
    }
);
