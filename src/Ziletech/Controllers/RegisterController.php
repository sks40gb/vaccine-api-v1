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

class RegisterController extends BaseController {

    /**
     *
     * @var PlanFactory
     */
    private $planFactory;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->planFactory = PlanFactory::getFactory($this->daoFactory);
    }

    /**
     * Add the user and active it.
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return type
     */
    public function registerAndActivate(Request $request, Response $response, array $args) {
        $userTreeDTO = $this->mapper->map($request->getParams(), DTOFactory::getUserTreeDTO());
        $this->register($request, $response, $args);
        $userTree = $this->planFactory->getRegisterService()->activateUser($userTreeDTO->getUser()->getUserName());
        return $response->withJson($userTree);
    }

    /**
     * Just add the user into User Table
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return type
     */
    public function register(Request $request, Response $response, array $args) {
        $userTreeDTO = $this->mapper->map($request->getParams(), DTOFactory::getUserTreeDTO());
        $this->validateSaveReferenceUser($request->getParams());
        $userTreeDTO->getUser()->setOwner($userTreeDTO->getOwner());
        //@TODO - move to constant file
        $userTreeDTO->getUser()->setReferralId(uniqid("ALKA"));
        $user = $this->planFactory->getRegisterService()->addUser($userTreeDTO);
        return $response->withJson($user->getId());
    }

    private function validateSaveReferenceUser($values) {
        $validation = $this->validator->validateArray($values, [
            'owner' => v::notEmpty()->attribute(
                    "userName", v::notEmpty()
                            ->not(v::create()->existsInTable($this->daoFactory->getUserDAO(), 'userName'))
            ),
            'user' => v::notEmpty()->attribute("name", v::notEmpty())
                    ->attribute("email", v::notEmpty()->email())
                    ->attribute("phone", v::notEmpty())
                    ->attribute("dob", v::notEmpty())
                    ->attribute("gender", v::notEmpty())
                    ->attribute("password", v::notEmpty())
                    ->attribute("country", v::notEmpty())
                    ->attribute("userName", v::notEmpty()->existsInTable($this->daoFactory->getUserDAO(), 'userName', 'id'))
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

}
