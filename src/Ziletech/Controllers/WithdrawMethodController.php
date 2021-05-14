<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Exceptions\ValidationException;
use Ziletech\Services\WithdrawMethodService;

class WithdrawMethodController extends BaseController {

    private $withdrawMehtodService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->withdrawMehtodService = new WithdrawMethodService($this->daoFactory);
    }

    public function get(Request $request, Response $response, array $args) {
        $this->validateWithdrawMethodId($args);
        $withdrawMethod = $this->daoFactory->getWithdrawMethodDAO()->findById($args['id']);
        return $response->withJson($this->withdrawMehtodService->convertTOWithdrawMethodDTO($withdrawMethod));
    }

    public function getWithdrawMethodsForuser(Request $request, Response $response, array $args) {
        $withdrawList = $this->daoFactory->getWithdrawMethodDAO()->getActiveWithdrawMethod();
        return $response->withJson($this->withdrawMehtodService->convertToWithdraMethodDTOList($withdrawList));
    }

    public function getAllMethod(Request $request, Response $response, array $args) {
        $withdrawList = $this->daoFactory->getWithdrawMethodDAO()->findAll();
        return $response->withJson($this->withdrawMehtodService->convertToWithdraMethodDTOList($withdrawList));
    }

    public function save(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validateWithdrawMethodOnSave($param);
        $withdrawMethodDTO = $this->mapper->map($param, DTOFactory::getWithdrawMethodDTO());
        return $response->withJson($this->withdrawMehtodService->saveMethod($withdrawMethodDTO));
    }

    public function update(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validateWithdrawMethodOnUpdate($param);
        $withdrawMethodDTO = $this->mapper->map($param, DTOFactory::getWithdrawMethodDTO());
        return $response->withJson($this->withdrawMehtodService->updateMethod($withdrawMethodDTO));
    }

    private function validateWithdrawMethodOnSave($values) {
        $validation = $this->validator->validateArray($values, [
            'name' => v::notEmpty(),
            'duration' => v::notEmpty(),
            'status' => v::boolVal()
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
        return $validation;
    }

    private function validateWithdrawMethodOnUpdate($values) {
        $validation = $this->validateWithdrawMethodOnSave($values);
        if (!$validation->failed()) {
            $validation = $this->validator->validateArray($values, [
                'id' => v::not(v::create()->existsInTable($this->daoFactory->getWithdrawMethodDAO(), 'id')),
            ]);
        }
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    private function validateWithdrawMethodId($values) {
        $validation = $this->validator->validateArray($values, [
            'id' => v::not(v::create()->existsInTable($this->daoFactory->getWithdrawMethodDAO(), 'id')),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

}
