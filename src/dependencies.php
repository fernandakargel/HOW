<?php
// DIC configuration

$container = $app->getContainer();


//  Register logger component on container
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};


//  Register database component on container 
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['pass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};


//  Register render component on container
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};


// Register view component on container
$container['view'] = function ($c) {
    $settings = $c->get('settings')['twing'];
    $view = new \Slim\Views\Twig('../src/Templates', [
        'debug' => $settings['debug'],
        'cache' => $settings['cache']
    ]);
    
    // Instantiate and add Slim specific extension
    $router = $c->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri)); 
    $view->addExtension(new \Twig_Extension_Debug());
    return $view;
};

// Register flash messages
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

// Register Session component on container
$container['session'] = function ($c) {
    return new \SlimSession\Helper;
};