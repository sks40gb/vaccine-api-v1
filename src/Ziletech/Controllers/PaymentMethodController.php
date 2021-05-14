<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Exceptions\ValidationException;
use Ziletech\Services\PaymentMethodService;

class PaymentMethodController extends BaseController {

    private $paymentMethodService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->paymentMethodService = new PaymentMethodService($this->daoFactory);
    }

    public function get(Request $request, Response $response, array $args) {
        $this->validatePaymentMethodId($args);
        $payment = $this->daoFactory->getPaymentMethodDAO()->findById($args['id']);
        return $response->withJson($this->paymentMethodService->convertToPaymentMethodDTO($payment));
    }

    public function save(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validatePaymentMethodOnSave($param);
        $paymentMethodDTO = $this->mapper->map($param, DTOFactory::getPaymentMethodDTO());
        return $response->withJson($this->paymentMethodService->savePaymentMethod($paymentMethodDTO));
    }

    public function update(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validatePaymentMethodOnUpdate($param);
        $paymentMethodDTO = $this->mapper->map($param, DTOFactory::getPaymentMethodDTO());
        return $response->withJson($this->paymentMethodService->updatePaymentMethod($paymentMethodDTO));
    }

    public function updateAutometicMethod(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $paymentMethodList = $this->mapper->map($param, DTOFactory::getPaymentMethodDTO());
        $this->paymentMethodService->updateAutometicMethod($paymentMethodList);
        return $response->withSuccess("Update succesfully");
    }

    public function remove(Request $request, Response $response, array $args) {
        $this->validatePaymentMethodId($args);
        $paymentMethod = $this->daoFactory->getPaymentMethodDAO()->findById($args['id']);
        $this->daoFactory->getPaymentMethodDAO()->remove($paymentMethod);
        return $response->withSuccess("Delete succesfully");
    }

    public function allManualPaymentMethod(Request $request, Response $response, array $args) {
        return $response->withJson($this->paymentMethodService->getMenualPaymentMethodList());
    }

    public function allActiveManualPaymentMethod(Request $request, Response $response, array $args) {
        return $response->withJson($this->paymentMethodService->getActiveMenualPaymentMethodList());
    }
    
     public function allAutometicPaymentMethod(Request $request, Response $response, array $args) {
          return $response->withJson($this->paymentMethodService->allAutometicPaymentMethod());
    }

    private function validatePaymentMethodOnSave($values) {
        $validation = $this->validator->validateArray($values, [
            'name' => v::notEmpty(),
            'fix' => v::noWhitespace()->numeric(),
            'percent' => v::noWhitespace()->numeric(),
            'description' => v::notEmpty(),
            'status' => v::boolVal()
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
        return $validation;
    }

    private function validatePaymentMethodOnUpdate($values) {
        $validation = $this->validatePaymentMethodOnSave($values);
        if (!$validation->failed()) {
            $validation = $this->validator->validateArray($values, [
                'id' => v::not(v::create()->existsInTable($this->daoFactory->getPaymentMethodDAO(), 'id')),
            ]);
        }
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    private function validatePaymentMethodId($values) {
        $validation = $this->validator->validateArray($values, [
            'id' => v::not(v::create()->existsInTable($this->daoFactory->getPaymentMethodDAO(), 'id')),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

}
