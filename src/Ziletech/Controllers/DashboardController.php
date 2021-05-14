<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Services\DashboardService;

class DashboardController extends BaseController {
    
    
    private $dashbardService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->dashbardService = new DashboardService($this->daoFactory);
    }

    public function getUserStatistics(Request $request, Response $response, array $args) {
        return $response->withJson($this->dashbardService->getUserStatistics());
    }

    public function getDepositStatistics(Request $request, Response $response, array $args) {
        return $response->withJson($this->dashbardService->getDepositStatistics());
    }

    public function getDepositPlanStatistics(Request $request, Response $response, array $args) {
        return $response->withJson($this->dashbardService->getDepositPlanStatistics());
    }

    public function getWithdrawStatistics(Request $request, Response $response, array $args) {
        return $response->withJson($this->dashbardService->getWithdrawStatistics());
    }

    public function getDashboardToolbar(Request $request, Response $response, array $args) {
        return $response->withJson($this->dashbardService->getDashboardToolbar());
    }

    public function getUserDashboardToolbar(Request $request, Response $response, array $args) {
        return $response->withJson($this->dashbardService->getUserDashboardToolbar($this->getCurrentUser($request)));
    }

}
