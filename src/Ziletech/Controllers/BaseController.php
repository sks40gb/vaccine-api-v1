<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Monolog\Logger;
use Phinx\Migration\Manager;
use Respect\Validation\Validator;
use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\DTOMapper;
use Ziletech\Database\Entity\User;
use Ziletech\Services\Auth\Auth;

class BaseController {

    /**
     * @var ContainerInterface
     */
    protected $container;

    /** @var DAOFactory */
    protected $daoFactory;

    /** @var Auth */
    protected $auth;

    /** @var Manager */
    protected $fractal;

    /** @var Validator */
    protected $validator;

    /** @var Logger */
    protected $logger;

    /** @var DTOMapper */
    protected $mapper;

    /**
     * BaseController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->auth = $container->get('auth');
        $this->fractal = $container->get('fractal');
        $this->daoFactory = $container->get('daoFactory');
        $this->validator = $container->get('validator');
        $this->logger = $container->get('logger');
        $this->mapper = new DTOMapper();
    }

    protected function getCurrentUser($request): User {
        return $this->auth->requestUser($request);
    }

    protected function getAppId($request) {
        return $this->daoFactory->getAppDAO()->getByKey($request->getParam("apikey"));
    }

    protected function getRequestedUrl() {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;
    }

}
