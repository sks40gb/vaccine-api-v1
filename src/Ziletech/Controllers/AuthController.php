<?php

namespace Ziletech\Controllers;

use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Models\UserModel;
use Ziletech\Services\User\UserService;
use Ziletech\Validation\Validator;

class AuthController extends BaseController {

    /**
     * Return token after successful login
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
    public function refreshCurrentUser(Request $request, Response $response, $userParams) {
        $currentUser = $this->getCurrentUser($request);
        $currentUser->token = $this->auth->generateToken($currentUser);
        $userService = new UserService($this->daoFactory);
        //respone content
        $userModel = new UserModel($currentUser);
        $userModel->setReferralLink($userService->generateUserReferralLink($currentUser));
        return $response->withJson($userModel);
    }

    public function login(Request $request, Response $response, $userParams) {
        $userParams["userId"] = $request->getParam('username');
        $userParams["password"] = $request->getParam('password');

        $validation = $this->validateLoginRequest($userParams);

        if ($validation->failed()) {
            return $response->withJson(['errors' => ['username or password' => ['is invalid']]], 422);
        }

        if ($user = $this->auth->attempt($userParams['userId'], $userParams['password'])) {
            $user->token = $this->auth->generateToken($user);
            $userService = new UserService($this->daoFactory);
            $userModel = new UserModel($user);
            $userModel->setReferralLink($userService->generateUserReferralLink($user));
            return $response->withJson($userModel);
        };
        return $response->withJson(['errors' => ['email or password' => ['is invalid']]], 422);
    }

    public function loginAs(Request $request, Response $response, $userParams) {
        $user = $this->daoFactory->getUserDAO()->getByUserName($userParams["username"]);
        if ($user != null) {
            $user->token = $this->auth->generateToken($user);
            $userService = new UserService($this->daoFactory);
            $userModel = new UserModel($user);
            $userModel->setReferralLink($userService->generateUserReferralLink($user));
            return $response->withJson($userModel);
        };
        return $response->withJson(['errors' => ['email or password' => ['is invalid']]], 422);
    }

    /**
     * This will generate the password reset token if the valid email is provided.
     * @param Request $request
     * @param Response $response
     * @param type $userParams
     * @return type
     */
    public function requestPassword(Request $request, Response $response, $userParams) {
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
     * It will reset the password
     * @param Request $request
     * @param Response $response
     * @param type $userParams
     * @return type
     */
    public function resetPassword(Request $request, Response $response, $userParams) {
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
            return $response->withSuccess("Reset email is sent to your email.");
        }
    }

    /**
     * @param array
     *
     * @return Validator
     */
    protected function validateLoginRequest($values) {
        return $this->validator->validateArray($values, [
                    'userId' => v::noWhitespace()->notEmpty(),
                    'password' => v::noWhitespace()->notEmpty(),
        ]);
    }

}
