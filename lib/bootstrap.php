<?php
require_once('Autoloader.php');

//autoload classess
$autoloader = new Autoloader();
$autoloader->addNamespace('Adnane\\', 'lib/Adnane/');
$autoloader->addNamespace('Application\\', 'src/Application/');
$autoloader->addNamespace('DI\\', 'lib/DI/');
$autoloader->addNamespace('Http\\', 'lib/Http/');
$autoloader->addNamespace('Router\\', 'lib/Router/');
$autoloader->addNamespace('Template\\', 'lib/Template/');
$autoloader->addNamespace('DB\\', 'lib/DB/');
$autoloader->register();

$baseDir = explode(DIRECTORY_SEPARATOR, __DIR__);
array_pop($baseDir);
$baseDir = implode(DIRECTORY_SEPARATOR, $baseDir);
$container = \DI\Container::getContainer();

/** @var \Http\Session $session */
$session = \DI\Container::getService('session');

$map = include('config/routes.php');
$router = new \Router\Router($map);

$request = \Http\Request::createFromGlobale();
$container->addService('request', $request);
$response = $container::getService('response');
$view = $container::getService('view');
$response->setView($view);

include 'config/db_config.php';
$db = \DI\Container::getService('db');

















//define('TCHAT_DIR', $base_dir);