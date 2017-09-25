<?php
require_once 'lib/bootstrap.php';

$container = \DI\Container::getContainer();

$view = $container::getService('view');
$view->setViewsDir($baseDir . '/src/Application/View');
$view->setLayout($baseDir . '/src/Application/View/base_layout.php');

$page = $request->getQueryParameter("page");

if (empty($page) || !$router->check($page)) {
    $response = $container::getService('response');
    $response
        ->setStatusCode(404)
        ->setTemplate('Errors/404.php')
        ->render()
        ->send();
    die;
}

$controller_ = $router->getAction($page);

if ($page != 'login' && !$session->hasData('user')){
    $response->redirect($request->getUri().'?page=login');
}

$controller = new $controller_[0];
$action = $controller_[1];
$user = \DI\Container::getService('user');

$controllerResponse = call_user_func([$controller, $action]);

if (!$controllerResponse instanceof \Http\Response) {
    throw new Exception('Controller mast return a Response object.');
}

$controllerResponse->send();

