<?php

namespace Ziletech\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\DTOMapper;
use Ziletech\Database\Entity\EntityFactory;

class CenterController extends BaseController {

    public function save(Request $request, Response $response, array $args) {
        $param = $request->getParams();
       // $this->validateGenericCodeOnSave($param);
        $mapper = new DTOMapper();
        $centersDTO = $mapper->map($param, DTOFactory::getCentersDTO());
        $genericCode = EntityFactory::getGenericCode();
        return $response->withJson($this->getById($genericCode->getId()));
    }

}
