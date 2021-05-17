<?php

namespace Ziletech\Services\Common;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DAO\Property;

class GenericCodeService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;


    public function __construct(DAOFactory $daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function getDescription($codeTypeCode, $gcCode): string {
        $filters = array();
        $codeType = $this->daoFactory->getCodeTypeDAO()->get(["description" => $codeTypeCode]);
        array_push($filters, Property::getInstance("codeType", $codeType->getId()));
        array_push($filters, Property::getInstance("code", $gcCode));
        $results = $this->daoFactory->getGenericCodeDAO()->filter($filters);
        return $results[0]->getDescription();
    }

}
