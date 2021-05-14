<?php

namespace Ziletech\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Database\DAO\Property;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Services\Common\DropdownService;

class DropdownController extends BaseController {

    public function type(Request $request, Response $response) {
        $code = $request->getAttribute("code");
        $dropdownService = new DropdownService($this->daoFactory);
        return $response->withJson($dropdownService->getByCode($code));
    }

    public function codeType(Request $request, Response $response) {
        $code = $request->getAttribute("code");
        return $response->withJson($this->getListByCode($code));
    }

    public function codeTypeByPost(Request $request, Response $response) {
        $parms = $request->getParams();
        $code = $parms["code"];
        return $response->withJson($this->getListByCode($code));
    }

    public function getListByCode($code) {
        $dropdownService = new DropdownService($this->daoFactory);
        return $dropdownService->getByCode($code);
    }

    public function findGeneriCodeByCodeType(Request $request, Response $response) {
        $code = $request->getAttribute("code");
        return $response->withJson($this->findByCodeType($code));
    }

    public function findByCodeType($code) {
        $filters = array();
        $codeType = $this->daoFactory->getCodeTypeDAO()->get(["description" => $code]);
        array_push($filters, Property::getInstance("codeType", $codeType->getId()));
        $results = $this->daoFactory->getGenericCodeDAO()->filter($filters);
        $genericCodeDTOList = [];
        foreach ($results as $genericCode) {
            $genericCodeDTO = DTOFactory::getGenericCodeDTO();
            $genericCodeDTO->copyFromDomain($genericCode);
            array_push($genericCodeDTOList, $genericCodeDTO);
        }
        return $genericCodeDTOList;
    }

}
