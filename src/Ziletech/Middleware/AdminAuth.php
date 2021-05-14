<?php

namespace Ziletech\Middleware;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ziletech\Database\DAO\DAOFactory;

class AdminAuth {

    /**
     * @var ContainerInterface
     */
    private $container;

    /** @var Auth */
    protected $auth;

    /**
     * ApiAuth constructor.
     *
     * @param ContainerInterface $container
     *
     * @internal param \Slim\Middleware\JwtAuthentication $jwt
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->auth = $container->get('auth');
    }

    /**
     * ApiAuth middleware invokable class to verify JWT token when present in Request
     *
     * @param  ServerRequestInterface $request  PSR7 request
     * @param  ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return ResponseInterface
     */
    public function __invoke($request, $response, $next) {
        $token = $request->getAttribute('token');
        $currentUser = $this->auth->requestUser($request);
        /* If token cannot be found return with 401 Unauthorized. */
        if($currentUser != null && $currentUser->getRole()->getName() == "ADMIN"){
            return $next($request, $response);
        }
        return $response->withStatus(403);
    }


}
