<?php

use Slim\Http\Body;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\AuthController;
use Ziletech\Controllers\AutocompleterController;
use Ziletech\Controllers\DropdownController;
use Ziletech\Controllers\FileController;
use Ziletech\Controllers\GenericCodeController;
use Ziletech\Controllers\RegisterController;
use Ziletech\Controllers\SettingController;
use Ziletech\Controllers\UserController;

// Api Routes
$app->group('/api', function () use ($app) {

    $userAuth = $this->getContainer()->get('jwt');
    $optionalAuth = $this->getContainer()->get('optionalAuth');
    $adminAuth = $this->getContainer()->get('adminAuth');

    /** Admin Routes * */
    $app->group('/admin', function() use ($app) {

        //auth
        $this->get('/auth/sign-in-as/{username}', AuthController::class . ':loginAs');

        //user
        $this->get('/user/{id}', UserController ::class . ':get');
        $this->delete('/user/{id}', UserController ::class . ':remove');
        $this->get('/user/status/change/{id}/{status}', UserController ::class . ':setUserStatus');
        $this->post('/user/search', UserController ::class . ':search');
        $this->get('/user/activate/{username}', UserController ::class . ':activateUser');

        //setting
        $this->get('/setting/{type}', SettingController::class . ':get');
        $this->put('/setting/{type}', SettingController::class . ':update');

        // Register
        $this->post('/register', RegisterController::class . ':registerAndActivate');

        // Generic Code
        $this->get('/generic-code/{id}', GenericCodeController ::class . ':get');
        $this->post('/generic-code/find', GenericCodeController ::class . ':find');
        $this->post('/generic-code', GenericCodeController ::class . ':save');
        $this->put('/generic-code', GenericCodeController ::class . ':update');
        $this->delete('/generic-code/{id}', GenericCodeController ::class . ':remove');

    })->add($adminAuth)->add($userAuth);

    // User Routes
    $app->group('', function() use ($app) {

        //autocompleter
        $this->get('/autocompleter/table/get/{table}/{column}/{searchText}', AutocompleterController::class . ':findByTableAndColumn');
        $this->get('/autocompleter/table/{table}/{column}/{searchText}', AutocompleterController::class . ':findByTableAndColumn');
        $this->get('/autocompleter/table/{table}/{column}', AutocompleterController::class . ':findByTableAndColumn');
        $this->get('/autocompleter/query/{queryName}/{searchText}', AutocompleterController::class . ':findByQuery');
        $this->get('/autocompleter/query/{queryName}', AutocompleterController::class . ':findByQuery');
        $this->get('/autocompleter/table/find/{table}/{column}/{searchText}', AutocompleterController::class . ':findByTableAndColumn');
        $this->get('/autocompleter/table/find/{table}/{column}', AutocompleterController::class . ':findByTableAndColumn');

        //Dropdown
        $this->get('/dropdown/type/{code}', DropdownController::class . ':type');
        $this->get('/dropdown/codetype/{code}', DropdownController::class . ':type');
        $this->get('/dropdown/genericcode/bycodetype/{code}', DropdownController::class . ':findGeneriCodeByCodeType');

        //file
        $this->post('/file/upload', FileController::class . ':upload');
        $this->delete('/file/{id}', FileController::class . ':delete');

        //user 
        $this->get('/user/by-login-name/{loginName}', UserController ::class . ':getByLoginName');
        $this->get('/user/confirm/{id}', UserController ::class . ':setConfirmStatus');
        $this->get('/user/new/{id}', UserController ::class . ':getNewUserList');
        $this->get('/user/balance/{id}', UserController ::class . ':getUserBalance');
        $this->get('/user/available-balance', UserController ::class . ':getBalance');
        $this->put('/user', UserController ::class . ':update');
        $this->get('/user/profile', UserController ::class . ':myProfile');
        $this->get('/auth/current/refresh', AuthController::class . ':refreshCurrentUser');

    })->add($userAuth);

    // Anonymous Routes
    $app->group('', function() use ($app) {
        $this->post('/dropdown/common', DropdownController::class . ':codeTypeByPost');
        $this->post('/auth/sign-in', AuthController::class . ':login')->setName('auth.login');
        $this->post('/auth/request-pass', AuthController::class . ':requestPassword')->setName('auth.requestPassword');
        $this->put('/auth/reset-pass', AuthController::class . ':resetPassword')->setName('auth.resetPassword');
        $this->get('/file/download/{id}', FileController::class . ':download');
        //Register
        $this->post('/register', RegisterController::class . ':register');
    });
});

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


//remove the NULL values from the response.
$app->add(function ($request, $response, $next) {
    $response = $next($request, $response);

    if ($response->getHeaderLine('Content-type') == 'application/json;charset=utf-8') {
        $content = (string) $response->getBody();
        $newBody = new Body(fopen('php://temp', 'r+'));
        $newBody->write(preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', $content));
        $response = $response->withBody($newBody);
    }
    return $response;
});
