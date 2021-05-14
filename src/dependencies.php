<?php

// DIC configuration

/** @var Pimple\Container $container */
use Ziletech\Middleware\OptionalAuth;
use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;
use \Ziletech\Middleware\AdminAuth;

$container = $app->getContainer();


// Error Handler
$container['errorHandler'] = function ($c) {
    return new \Ziletech\Exceptions\ErrorHandler($c['settings']['displayErrorDetails']);
};

// App Service Providers
$container->register(new \Ziletech\Services\Database\EloquentServiceProvider());
$container->register(new \Ziletech\Services\Auth\AuthServiceProvider());
$container->register(new \Foundation\DatabaseServiceProvider());

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];

    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

// Jwt Middleware
$container['jwt'] = function ($c) {

    $jws_settings = $c->get('settings')['jwt'];

    return new \Slim\Middleware\JwtAuthentication($jws_settings);
};

$container['optionalAuth'] = function ($c) {
    return new OptionalAuth($c);
};


$container['adminAuth'] = function ($c) {
    return new AdminAuth($c);
};

// Request Validator
$container['validator'] = function ($c) {
    \Respect\Validation\Validator::with('\\Ziletech\\Validation\\Rules');

    return new \Ziletech\Validation\Validator();
};

// Fractal
$container['fractal'] = function ($c) {
    $manager = new Manager();
    $manager->setSerializer(new ArraySerializer());

    return $manager;
};

// Use our Response class instead of the default. This sets some extra values on JSON responses.
$container['response'] = function ($slimContainer) {
    //$headers = new Slim\Http\Headers(['Content-Type' => 'text/html; charset=UTF-8']);
    $headers = new Slim\Http\Headers([]);
    $response = new ZResponse(200, $headers);
    return $response->withProtocolVersion($slimContainer->get('settings')['httpVersion']);
};
