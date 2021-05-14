<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Services\Plan\Core\Transaction\TransactionService;

class TransactionController extends BaseController {

    private $transactionService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->transactionService = new TransactionService($this->daoFactory);
    }

    public function search(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        return $response->withJson($this->transactionService->search($param));
    }
    
    public function searchCurrentUserTransaction(Request $request, Response $response, array $args) {
        return $response->withJson($this->transactionService->currentUserTrasactionList($this->getCurrentUser($request)));
    }

}
