<?php

namespace Ziletech\Services\Common;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DAO\StatusType;

class DropdownService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function getByCode($code): array {
        switch ($code) {
            case "USERS":
                return $this->getUsers();
            case "USER_NAME":
                return $this->getUserNameList();
            case "DISTRICT":
                return $this->getDistrict();
            case "USER_STATUS":
                return $this->getUserStatus();
            default :
                throw new \Exception("Invalid Dropdown code ");
        }
    }


    private function getUsers() {
        $users = $this->daoFactory->getUserDAO()->findAll();
        $items = $this->getArrayWithEmptyItem();
        foreach ($users as $user) {
            $model = new KeyValue($user->getId(), $user->getUserName());
            array_push($items, $model);
        }
        return $items;
    }

    private function getUserNameList(): array {
        $users = $this->daoFactory->getUserDAO()->findAll();
        $items = $this->getArrayWithEmptyItem();
        foreach ($users as $user) {
            $model = new KeyValue($user->getUserName(), $user->getUserName());
            array_push($items, $model);
        }
        return $items;
    }

    private function getUserStatus(): array {
        $statusList = array();
        array_push($statusList, new KeyValue(StatusType::USER_ACTIVE, "ACTIVETED USER"));
        array_push($statusList, new KeyValue(StatusType::USER_DEACTIVE, "BLOCKED USER"));
        array_push($statusList, new KeyValue(StatusType::NEW_USER, "NEW USER"));
        return $statusList;
    }

    private function getDistrict(): array {
        $codeTypeCountry = $this->daoFactory->getCodeTypeDAO()->getByCode("DISTRICT");
        $items = $this->getArrayWithEmptyItem();
        foreach ($codeTypeCountry->getGenericCodes() as $country) {
            $model = new KeyValue($country->getCode(), $country->getDescription());
            array_push($items, $model);
        }
        return $items;
    }

    private function getArrayWithEmptyItem(): array {
        $items = array();
        $model = new KeyValue("", "-- Select --");
        array_push($items, $model);
        return $items;
    }

}

class KeyValue {

    public $id, $text, $keyValue;

    public function __construct($key, $value) {
        $this->id = $key;
        $this->text = $value;
        $this->keyValue = $key . "-" . $value;
    }

}
