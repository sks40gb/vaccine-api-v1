<?php

// Application middleware
// e.g: $app->add(new \Slim\Csrf\Guard);

use Slim\Http\Request;
use Slim\Http\Response;

$app->add(function (Request $request, Response $response, callable $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));

        if ($request->getMethod() == 'GET') {
            return $response->withRedirect((string) $uri, 301);
        } else {
            return $next($request->withUri($uri), $response);
        }
    }

    return $next($request, $response);
});


$app->add(function ($request, $response, $next) {
    // add media parser
    $request->registerMediaTypeParser(
            "application/json", function ($input) {
        return json_decode($input);
    });
    return $next($request, $response);
});
