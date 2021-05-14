<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Exceptions\ValidationException;
use Ziletech\Services\WithdrawService;

class WithdrawController extends BaseController {

    private $withdrawService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->withdrawService = new WithdrawService($this->daoFactory);
    }

    public function findForCurrentUser(Request $request, Response $response, array $args) {
        $status = $request->getAttribute("status");
        $withdrawList = null;
        if ($status == null) {
            $withdrawList = $this->withdrawService->getAllWithdrawList($this->getCurrentUser($request));
        } else {
            $withdrawList = $this->withdrawService->findByStatus($status);
        }
        return $response->withJson($withdrawList);
    }

    public function find(Request $request, Response $response, array $args) {
        $status = $request->getAttribute("status");
        $withdrawList = null;
        if ($status == null) {
            $withdrawList = $this->withdrawService->getAllWithdrawList();
        } else {
            $withdrawList = $this->withdrawService->findByStatus($status);
        }
        return $response->withJson($withdrawList);
    }

    public function withdrawRefund(Request $request, Response $response, array $args) {
        $this->validateWithdrawLogId($args);
        return $response->withJson($this->withdrawService->cancelWithdraw($args["id"]));
    }

    public function getAdminAndTDSCharges(Request $request, Response $response, array $args) {
        return $response->withJson($this->withdrawService->getCharges());
    }

    public function save(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validateWithdrawLogOnSave($param);
        $fundRequestDTO = $this->mapper->map($param, DTOFactory::getCalulateWithdrawFundRequestDTO());
        $user = $this->getCurrentUser($request);
        $withdrawLog = $this->withdrawService->copyToWithdrawLog($fundRequestDTO, $user);
        $this->daoFactory->getWithdrawLogDAO()->save($withdrawLog);
        return $response->withSuccess("withdraw requested");
    }

    public function viewWithdrawRequest(Request $request, Response $response, array $args) {
        $withdrawLog = $this->daoFactory->getWithdrawLogDAO()->findById($args['id']);
        return $response->withJson($this->withdrawService->convertToWithdrawDTO($withdrawLog));
    }

    public function approveWithdraw(Request $request, Response $response, array $args) {
        $this->validateWithdrawLogId($args);
        $withdrawLog = $this->withdrawService->approveWithdraw($args["id"]);
        return $response->withJson($this->withdrawService->convertToWithdrawDTO($withdrawLog));
    }

    public function minimumWithdraw(Request $request, Response $response, array $args) {
        $minimumWithdraw = $this->daoFactory->getGenericCodeDAO()->getByCode('MINIMUM_WITHDRAW')->getDescription();
        return $response->withJson($minimumWithdraw);
    }

    private function validateWithdrawLogOnSave($values) {
        $validation = $this->validator->validateArray($values, [
            'amount' => v::noWhitespace()->numeric(),
            'charge' => v::noWhitespace()->numeric(),
            'totalAmount' => v::noWhitespace()->numeric(),
            'message' => v::notEmpty(),
            'details' => v::notEmpty(),
            'withdrawMethodId' => v::notEmpty()->not(v::existsInTable($this->daoFactory->getWithdrawMethodDAO(), 'id')),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    private function validateWithdrawLogId($values) {
        $validation = $this->validator->validateArray($values, [
            'id' => v::not(v::create()->existsInTable($this->daoFactory->getWithdrawLogDAO(), 'id')),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

}
