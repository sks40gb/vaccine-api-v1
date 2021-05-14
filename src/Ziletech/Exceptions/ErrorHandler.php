<?php

namespace Ziletech\Exceptions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\Error;
use Slim\Http\StatusCode;

class ErrorHandler extends Error {

    /** @inheritdoc */
    public function __construct(bool $displayErrorDetails) {
        parent::__construct($displayErrorDetails);
    }

    /** @inheritdoc */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Exception $exception) {

        if (!$this->displayErrorDetails) {
            
            //Handle Validation Exception
            if ($exception instanceof ValidationException) {
                return $response->withJson(['errors' => $exception->getErrors()], StatusCode::HTTP_UNPROCESSABLE_ENTITY);
            }
            
            //Handle all other exception
            return $response->withJson( ['message' => $exception->getMessage()], StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        return parent::__invoke($request, $response, $exception);
    }

}
