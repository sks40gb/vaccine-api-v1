<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\DTOMapper;
use Ziletech\Exceptions\ValidationException;
use Ziletech\Services\SupportMessageService;
use Ziletech\Services\SupportService;

class SupportTicketController extends BaseController {

    private $supportService;
    private $supportMessegeService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->supportService = new SupportService($this->daoFactory);
        $this->supportMessegeService = new SupportMessageService($this->daoFactory);
    }

    public function getAllSupport(Request $request, Response $response, array $args) {
        $supportList = $this->daoFactory->getSupportDAO()->findAll(["orderBy" => "createdAt", "order" => "DESC"]);
        return $response->withJson($this->supportService->convertTOSupportDTOList($supportList));
    }

    public function getCurrentUserSupport(Request $request, Response $response, array $args) {
        $user = $this->getCurrentUser($request);
        return $response->withJson($this->supportService->convertTOSupportDTOList($user->getSupportList()));
    }

    public function closeSupport(Request $request, Response $response, array $args) {
        $this->validateId($args);
        return $response->withJson($this->supportService->closeSupport($args["id"]));
    }

    public function getAllPendingSupport(Request $request, Response $response, array $args) {
        $supportList = $this->daoFactory->getSupportDAO()->getPendingSupports();
        return $response->withJson($this->supportService->convertTOSupportDTOList($supportList));
    }

    public function get(Request $request, Response $response, array $args) {
        $this->validateId($args);
        $support = $this->daoFactory->getSupportDAO()->findById($args["id"]);
        return $response->withJson($this->supportService->convertTOSupportDTO($support));
    }

    public function getSupportMessegeByTicket(Request $request, Response $response, array $args) {
        $supportMessageList = $this->daoFactory->getSupportMessageDAO()->getSupportMessegeByTicket($args["ticket"]);
        return $response->withJson($this->supportMessegeService->convertToSupportMessageDTOList($supportMessageList));
    }

    public function answerToUserMessege(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validateOnSaveUserMessage($param);
        
        $supportMessageDTO = $this->mapper->map($param, DTOFactory::getSupportMessageDTO());
        $user = $this->getCurrentUser($request);
        return $response->withJson($this->supportMessegeService->answerToUserMessege($supportMessageDTO, $user));
    }

    public function saveUserMessage(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validateOnSaveUserMessage($param);
        $supportMessageDTO = $this->mapper->map($param, DTOFactory::getSupportMessageDTO());
        $user = $this->getCurrentUser($request);
        return $response->withJson($this->supportMessegeService->saveMessegeFromUser($supportMessageDTO, $user));
    }

    public function createNewTicket(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validateOnCreateNewTicketreateNewTicket($param);
        $messageRequestDTO = $this->mapper->map($param, DTOFactory::getOpenSupportMessageRequestDTO());
        $user = $this->getCurrentUser($request);
        $message = $this->supportMessegeService->createNewTicket($messageRequestDTO, $user);
        return $response->withJson(["id" => $message->getId()]);
    }

    private function validateId($values) {
        $validation = $this->validator->validateArray($values, [
            'id' => v::not(v::create()->existsInTable($this->daoFactory->getSupportDAO(), 'id')),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    private function validateOnCreateNewTicketreateNewTicket($values) {
        $validation = $this->validator->validateArray($values, [
            'subject' => v::notEmpty(),
            'message' => v::notEmpty(),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    private function validateOnSaveUserMessage($values) {
        $validation = $this->validator->validateArray($values, [
            'message' => v::notEmpty(),
            'support' => v::notEmpty()->attribute("id", v::notEmpty()->not(v::existsInTable($this->daoFactory->getSupportDAO(), 'id'))),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

}
