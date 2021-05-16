<?php

namespace Ziletech\Controllers;

use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Models\UserModel;
use Ziletech\Services\User\UserService;
use Ziletech\Validation\Validator;

class AuthController extends BaseController {

    /**
     * Return token after successful login
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function refreshCurrentUser(Request $request, Response $response, $userParams): Response {
        $currentUser = $this->getCurrentUser($request);
        $currentUser->token = $this->auth->generateToken($currentUser);
        $userService = new UserService($this->daoFactory);
        //response content
        $userModel = new UserModel($currentUser);
        return $response->withJson($userModel);
    }

    public function login(Request $request, Response $response, $userParams): Response {
        $userParams["userId"] = $request->getParam('username');
        $userParams["password"] = $request->getParam('password');

        $validation = $this->validateLoginRequest($userParams);

        if ($validation->failed()) {
            return $response->withJson(['errors' => ['username or password' => ['is invalid']]], 422);
        }

        if ($user = $this->auth->attempt($userParams['userId'], $userParams['password'])) {
            $user->token = $this->auth->generateToken($user);
            $userModel = new UserModel($user);
            return $response->withJson($userModel);
        };
        return $response->withJson(['errors' => ['email or password' => ['is invalid']]], 422);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $userParams
     * @return Response
     */
    public function requestPassword(Request $request, Response $response, $userParams): Response {
        $email = $request->getParam('email');
        $userDAO = $this->daoFactory->getUserDAO();
        $user = $userDAO->getByEmail($email);
        if ($user == null) {
            return $response->withJson(['errors' => ['email' => ['is invalid']]], 422);
        } else {
            $userService = new UserService($this->daoFactory);
            $userService->requestPasswordReset($email);
            return $response->withSuccess("Reset email is sent to your email.");
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $userParams
     * @return Response
     */
    public function resetPassword(Request $request, Response $response, $userParams): Response {
        $password = $request->getParam('password');
        $token = $request->getParam('reset_password_token');
        $userDAO = $this->daoFactory->getUserDAO();
        $user = $userDAO->getByResetPasswordToken($token);
        if ($user == null) {
            return $response->withJson(['errors' => 'Password reset link is invalid'], 422);
        } else {
            $user->setResetPasswordToken(null);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $userDAO->save($user);
            return $response->withSuccess("Password reset is completed successfully.");
        }
    }

    /**
     * @param array
     *
     * @return Validator
     */
    protected function validateLoginRequest($values): Validator {
        return $this->validator->validateArray($values, [
            'userId' => v::noWhitespace()->notEmpty(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);
    }

}
