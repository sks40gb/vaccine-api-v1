<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Exceptions\ValidationException;
use Ziletech\Services\Plan\Core\PlanFactory;
use Ziletech\Services\Plan\Core\Register\RegisterService;
use Ziletech\Services\User\UserService;
use Ziletech\Services\UserBalanceService;

class UserController extends BaseController {

    private $userService;
    private $userBalanceService;
    private $transactionService;
    /**
     *
     * @var RegisterService
     */
    private $registerService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->userService = new UserService($this->daoFactory);
        $this->userBalanceService = new UserBalanceService($this->daoFactory);
        $this->transactionService = PlanFactory::getFactory($this->daoFactory)->getTransactionService();
        $this->registerService = PlanFactory::getFactory($this->daoFactory)->getRegisterService();
    }

    public function get(Request $request, Response $response, array $args) {
        $this->validateId($args);
        $user = $this->daoFactory->getUserDAO()->findById($args["id"]);
        return $response->withJson($this->userService->convertToUserDTO($user));
    }

    public function myProfile(Request $request, Response $response, array $args) {
        return $response->withJson($this->userService->convertToUserDTO($this->getCurrentUser($request)));
    }

    public function getByLoginName(Request $request, Response $response, array $args) {
        return $response->withJson($this->userService->getByLoginName($args["loginName"]));
    }

    public function search(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        return $response->withJson($this->userService->search($param));
    }

    public function setUserStatus(Request $request, Response $response, array $args) {
        $this->validateUserWhenActivation($args);
        return $response->withJson($this->userService->setUserStatus($args["id"], $args["status"]));
    }

    public function remove(Request $request, Response $response, array $args) {
        $this->validateId($args);
        $this->userService->remove($args["id"]);
        return $response->withSuccess("Delete succesfully");
    }

    public function getUserBalance(Request $request, Response $response, array $args) {
        $this->validateId($args);
        return $response->withJson($this->daoFactory->getUserBalanceDAO()->getUserBalance($args['id']));
    }

    public function getBalance(Request $request, Response $response, array $args) {
        $user = $this->getCurrentUser($request);
        return $response->withJson($this->daoFactory->getUserBalanceDAO()->getUserBalance($user->getId()));
    }

    public function getUserListByOwnerId(Request $request, Response $response, array $args) {
        return $response->withJson($this->userService->getUserListByOwnerId($this->getCurrentUser($request)));
    }

    public function getNewUserList(Request $request, Response $response, array $args) {
        $this->validateId($args);
        return $response->withJson($this->userService->getNewUserList($id));
    }

    public function saveUserBalance(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validateOnBalanceSave($param);
        $requestDTO = $this->mapper->map($param, DTOFactory::getTransactionRequestDTO());
        $userBalance = $this->userService->updateUserBalance($requestDTO);
        return $response->withJson($userBalance->getId());
    }

    public function setConfirmStatus(Request $request, Response $response, array $args) {
        $this->validateId($args);
        return $response->withJson($this->userService->changeStatusToConfirm($args["id"]));
    }

    public function update(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $userDTO = $this->mapper->map($param, DTOFactory::getUserDTO());
        return $response->withJson($this->userService->update($userDTO));
    }

    public function activateUser(Request $request, Response $response, array $args) {
        $userTree = $this->registerService->activateUser($request->getAttribute("username"));
        return $response->withJson($userTree);
    }

    public function getSponserByReferralId(Request $request, Response $response, array $args) {
        $this->validateReferralId($args);
        $sponser = $this->userService->getUserByReferralId($request->getAttribute("referralId"));
        return $response->withJson($sponser);
    }

    public function getSponserByUserName(Request $request, Response $response, array $args) {
        $this->validateSponserUserName($args);
        $sponser = $this->userService->getSponserByUserName($request->getAttribute("name"));
        return $response->withJson($sponser);
    }

    public function validateUserName(Request $request, Response $response, array $args) {
        return $response->withJson($this->isUserNameExist($args));
    }

    private function validateUserWhenActivation($values) {
        $validation = $this->validator->validateArray($values, [
            'id' => v::not(v::create()->existsInTable($this->daoFactory->getUserDAO(), 'id')),
            'status' => v::notEmpty(),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    private function validateReferralId($values) {
        $validation = $this->validator->validateArray($values, [
            'referralId' => v::not(v::create()->existsInTable($this->daoFactory->getUserDAO(), 'referralId')),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    private function isUserNameExist($values) {
        $validation = $this->validator->validateArray($values, [
            'name' => v::create()->existsInTable($this->daoFactory->getUserDAO(), 'userName'),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    private function validateSponserUserName($values) {
        $validation = $this->validator->validateArray($values, [
            'name' => v::not(v::create()->existsInTable($this->daoFactory->getUserDAO(), 'userName')),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
        return true;
    }

    private function validateOnBalanceSave($values) {
        $validation = $this->validator->validateArray($values, [
            'id' => v::not(v::create()->existsInTable($this->daoFactory->getUserDAO(), 'id')),
            'operation' => v::numeric(),
            'amount' => v::noWhitespace()->numeric(),
            'reason' => v::notEmpty(),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    private function validateId($values) {
        $validation = $this->validator->validateArray($values, [
            'id' => v::not(v::create()->existsInTable($this->daoFactory->getUserDAO(), 'id')),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

}
