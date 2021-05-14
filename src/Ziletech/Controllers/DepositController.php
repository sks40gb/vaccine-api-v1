<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Database\DAO\StatusType;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Exceptions\ValidationException;
use Ziletech\Services\DepositService;

class DepositController extends BaseController {

    private $depositService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->depositService = new DepositService($this->daoFactory);
    }

    public function findForCurrentUser(Request $request, Response $response, array $args) {
        $status = $request->getAttribute("status");
        return $response->withJson($this->depositService->getDepositListByStatus($status, $this->getCurrentUser($request)));
    }

    public function find(Request $request, Response $response, array $args) {
        $status = $request->getAttribute("status");
        return $response->withJson($this->depositService->getDepositListByStatus($status));
    }

    public function getDepositRequests(Request $request, Response $response, array $args) {
        $this->validateDepositId($args);
        $deposit = $this->daoFactory->getDepositDAO()->findById($args['id']);
        return $response->withJson($this->depositService->convertToDepositDTO($deposit));
    }

    public function cancelDeposit(Request $request, Response $response, array $args) {
        $this->validateDepositId($args);
        return $response->withJson($this->depositService->cancelDeposit($args["id"]));
    }

    public function approveDeposit(Request $request, Response $response, array $args) {
        $this->validateDepositId($args);
        return $response->withJson($this->depositService->approveDeposit($args["id"]));
    }

    public function getStatus(Request $request, Response $response, array $args) {
        $user = $this->getCurrentUser($request);
        $isFullPayment = false;
        $depositAmount = 0;
        foreach ($user->getDepositList() as $deposit) {
            if ($deposit->status == StatusType::DEPOSIT_APPROVE_STATUS) {
                $depositAmount += $deposit->getAmount();
            }
        }
        if ($user->getPlan() != null && $depositAmount >= $user->getPlan()->getPrice()) {
            $isFullPayment = true;
        }
        return $response->withJson($isFullPayment);
    }

    public function save(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validateDepositOnSave($param);
        $fundRequestDTO = $this->mapper->map($param, DTOFactory::getCalulateDepositFundRequestDTO());
        $user = $this->getCurrentUser($request);
        $this->depositService->saveDeposit($fundRequestDTO, $user);
        return $response->withSuccess("deposit save successfully");
    }

    public function search(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        return $response->withJson($this->depositService->filter($param));
    }

    private function validateDepositId($values) {
        $validation = $this->validator->validateArray($values, [
            'id' => v::not(v::create()->existsInTable($this->daoFactory->getDepositDAO(), 'id')),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    private function validateDepositOnSave($values) {
        $validation = $this->validator->validateArray($values, [
            'charge' => v::noWhitespace()->numeric(),
            'netAmount' => v::noWhitespace()->numeric(),
            'amount' => v::noWhitespace()->numeric(),
            'paymentMethodId' => v::notEmpty()->not(v::existsInTable($this->daoFactory->getPaymentMethodDAO(), 'id')),
            'image' => v::notEmpty()->attribute("id", v::notEmpty()->not(v::existsInTable($this->daoFactory->getFileDAO(), 'id'))),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

}
