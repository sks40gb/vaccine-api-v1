<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Exceptions\ValidationException;
use Ziletech\Services\PlanService;

class PlanController extends BaseController {

    private $planService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->planService = new PlanService($this->daoFactory);
    }

    public function get(Request $request, Response $response, array $args) {
        $this->validateId($args);
        $plan = $this->daoFactory->getPlanDAO()->findById($args['id']);
        return $response->withJson($this->planService->convertToPlanDTO($plan));
    }

    public function getCurrentUserPlan(Request $request, Response $response, array $args) {
        $plan = $this->getCurrentUser($request)->getPlan();
        $planDTO = null;
        if ($plan) {
            $planDTO = $this->planService->convertToPlanDTO($plan);
        }
        return $response->withJson($planDTO);
    }

    public function save(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validatePlanOnSave($param);
        $planDTO = $this->mapper->map($param, DTOFactory::getPlanDTO());
        return $response->withJson($this->planService->savePlan($planDTO));
    }

    public function update(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validatePlanOnUpdate($param);
        $planDTO = $this->mapper->map($param, DTOFactory::getPlanDTO());
        return $response->withJson($this->planService->updatePlan($planDTO));
    }

    public function search(Request $request, Response $response, array $args) {
        return $response->withJson($this->planService->search());
    }

    public function remove(Request $request, Response $response, array $args) {
        $this->validateId($args);
        $this->planService->remove($args["id"]);
        return $response->withSuccess("Delete succesfully");
    }

    private function validateId($values) {
        $validation = $this->validator->validateArray($values, [
            'id' => v::not(v::create()->existsInTable($this->daoFactory->getPlanDAO(), 'id')),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    private function validatePlanOnSave($values) {
        $validation = $this->validator->validateArray($values, [
            'name' => v::notEmpty(),
            'price' => v::noWhitespace()->numeric(),
            'installmentPrice' => v::noWhitespace()->numeric(),
            'status' => v::boolVal(),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
        return $validation;
    }

    private function validatePlanOnUpdate($values) {
        $validation = $this->validatePlanOnSave($values);
        if (!$validation->failed()) {
            $validation = $this->validator->validateArray($values, [
                'id' => v::not(v::create()->existsInTable($this->daoFactory->getPlanDAO(), 'id')),
            ]);
        }
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

}
