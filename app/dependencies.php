<?php
// DIC configuration
error_reporting(1);

define(PASTA_LOGOS, 'https://cdn.rawgit.com/CobreGratis/boletophp/2.x-dev/imagens/'); 
$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------
// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view     = new Slim\Views\Twig($settings['view']['template_path'],
        $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'),
        $c->get('request')->getUri()));
    // $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

// Flash messages
$container['flash'] = function ($c) {
    return new Slim\Flash\Messages;
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------
// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger   = new Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['logger']['path'],
        Monolog\Logger::DEBUG));
    return $logger;
};

$container['mongodb'] = function ($c) {
    $m  = new MongoClient("mongodb://pbc-mongodb:27017",
        array("connect" => true), array()); // connect
    $db = $m->selectDB("pbc");
    return $db;
};

// -----------------------------------------------------------------------------
// Controller factories
// -----------------------------------------------------------------------------

$container[App\Controller\HomeController::class] = function ($c) {
    return new App\Controller\HomeController($c);
};

$container['remessa'] = function ($c) {
    return new App\Controller\RemessaController($c);
};

$container['boleto'] = function ($c) {
    return new App\Controller\BoletoController($c);
};
