<?php

namespace Ziletech\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Database\DAO\Property;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\DTOMapper;
use Ziletech\Database\DTO\GenericCodeDTO;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\GenericCode;
use Ziletech\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class GenericCodeController extends BaseController {

    public function get(Request $request, Response $response, array $args) {
        $this->validateId($args);
        return $response->withJson($this->getById($args['id']));
    }

    public function getById($id) {
        $genericCode = $this->daoFactory->getGenericCodeDAO()->findById($id);
        $genericCodeDTO = DTOFactory::getGenericCodeDTO();
        $genericCodeDTO->copyFromDomain($genericCode);
        $codeTypeDTO = DTOFactory::getCodeTypeDTO();
        $codeTypeDTO->copyFromDomain($genericCode->getCodeType());
        $genericCodeDTO->codeType = $codeTypeDTO;
        return $genericCodeDTO;
    }

    public function find(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $genericCodeDAO = $this->daoFactory->getGenericCodeDAO();

        $filters = array();

        $mapper = new DTOMapper();

        $gcDTO = $mapper->map($param, DTOFactory::getGenericCodeDTO());

        if (isset($gcDTO->codeType) && isset($gcDTO->codeType->id)) {
            array_push($filters, Property::getInstance("codeType", $gcDTO->codeType->id));
        }
        if (isset($gcDTO->code)) {
            array_push($filters, Property::getInstance("code", $gcDTO->code));
        }
        if (isset($gcDTO->description)) {
            array_push($filters, Property::getInstance("description", $gcDTO->description));
        }
        $genericCodeList = $genericCodeDAO->filter($filters, ["orderBy" => "description", "order" => "DESC"]);

        //Copy to DTO
        $genericCodeDTOList = array();
        foreach ($genericCodeList as $gc) {
            $gcDTO = DTOFactory::getGenericCodeDTO();
            $gcDTO->copyFromDomain($gc);
            $codeTypeDTO = DTOFactory::getCodeTypeDTO();
            $codeTypeDTO->copyFromDomain($gc->getCodeType());
            $gcDTO->codeType = $codeTypeDTO;
            array_push($genericCodeDTOList, $gcDTO);
        }
        return $response->withJson($genericCodeDTOList);
    }

    public function save(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validateGenericCodeOnSave($param);
        $mapper = new DTOMapper();
        $gcDTO = $mapper->map($param, DTOFactory::getGenericCodeDTO());
        $genericCode = EntityFactory::getGenericCode();
        $this->daoFactory->getGenericCodeDAO()->save($this->copyGenericCode($gcDTO, $genericCode));
        return $response->withJson($this->getById($genericCode->getId()));
    }

    public function update(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $this->validateGenericCodeOnUpdate($param);
        $mapper = new DTOMapper();
        $gcDTO = $mapper->map($param, DTOFactory::getGenericCodeDTO());
        //update entry
        $genericCode = $this->daoFactory->getGenericCodeDAO()->findById($gcDTO->id);
        $this->daoFactory->getGenericCodeDAO()->update($this->copyGenericCode($gcDTO, $genericCode));
        return $response->withJson($this->getById($genericCode->getId()));
    }

    public function remove(Request $request, Response $response, array $args) {
        $this->validateId($args);
        $genericCode = $this->daoFactory->getGenericCodeDAO()->findById($args['id']);
        $this->daoFactory->getGenericCodeDAO()->remove($genericCode);
        return $response->withSuccess("Generic Code deleted successfully");
    }

    public function copyGenericCode(GenericCodeDTO $genericCodeDTO, GenericCode $genericCode) {
        $codeType = $this->daoFactory->getCodeTypeDAO()->findById($genericCodeDTO->codeType->id);
        $genericCode->setCodeType($codeType);
        $genericCodeDTO->copyToDomain($genericCode);
        return $genericCode;
    }

    private function validateId($values) {
        $validation = $this->validator->validateArray($values, [
            'id' => v::not(v::create()->existsInTable($this->daoFactory->getGenericCodeDAO(), 'id')),
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    protected function validateGenericCodeOnSave($values) {
        // check if description is not empty and code type exists in database.
        $validation = $this->validator->validateArray($values, [
            'codeType' => v::notEmpty()->attribute("id", v::notEmpty()->not(v::existsInTable($this->daoFactory->getCodeTypeDAO(), 'id'))),
            'description' => v::notEmpty()
        ]);
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
        // while updating check code is unique.
        else if (!isset($values["id"])) {
            $this->validateGenericCodeUniqueCode($values);
        }
        return $validation;
    }

    protected function validateGenericCodeOnUpdate($values) {
        $validation = $this->validateGenericCodeOnSave($values);
        //If basic validation is success then check for additonal property
        if (!$validation->failed()) {
            $validation = $this->validator->validateArray($values, [
                'id' => v::not(v::create()->existsInTable($this->daoFactory->getGenericCodeDAO(), 'id')),
            ]);
        }
        if ($validation->failed()) {
            throw new ValidationException($validation->getErrors());
        }
    }

    private function validateGenericCodeUniqueCode($values) {
        $filterList = [];
        $code = $values["code"];
        // check generic code if already exists base on code type and code.
        array_push($filterList, Property::getInstance("codeType", $values["codeType"]->id));
        array_push($filterList, Property::getInstance("code", $code));
        if (!empty($this->daoFactory->getGenericCodeDAO()->filter($filterList))) {
            throw new ValidationException("Generic Code  with code $code already exists.");
        }
    }

}
