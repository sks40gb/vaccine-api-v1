<?php

namespace Ziletech\Services\Common;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Util\StringUtil;

class AutoCompleterService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function findByQuery($queryName, $searchText) {
        $queryService = new QueryService();
        $sql = $queryService->getQuery($queryName, $searchText);
        $result = $this->daoFactory->getGenericCodeDAO()->executeNativeQuery($sql);
        return $result;
    }

    public function findByTableAndColumn($table, $column, $searchText) {
        $sql = "SELECT * FROM $table ";
        if (StringUtil::isNotEmpty($searchText)) {
            $sql .= " WHERE $column  LIKE '%$searchText%'";
        }
        $result = $this->daoFactory->getGenericCodeDAO()->executeNativeQuery($sql);
        return $result;
    }

    public function getByTableAndColumn($table, $column, $searchText) {
        $sql = "SELECT * FROM $table ";
        if (StringUtil::isNotEmpty($searchText)) {
            $sql .= " WHERE $column  LIKE '%$searchText%'";
}
        $result = $this->daoFactory->getGenericCodeDAO()->executeNativeQuery($sql);
        return $result;
    }

}
