<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Exceptions\ValidationException;
use Ziletech\Services\User\UserService;

class UserController extends BaseController {

    private $userService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->userService = new UserService($this->daoFactory);
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

    public function getNewUserList(Request $request, Response $response, array $args) {
        $this->validateId($args);
        return $response->withJson($this->userService->getNewUserList($id));
    }

    public function update(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $userDTO = $this->mapper->map($param, DTOFactory::getUserDTO());
        return $response->withJson($this->userService->update($userDTO));
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

    private function isUserNameExist($values) {
        $validation = $this->validator->validateArray($values, [
            'name' => v::create()->existsInTable($this->daoFactory->getUserDAO(), 'userName'),
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
