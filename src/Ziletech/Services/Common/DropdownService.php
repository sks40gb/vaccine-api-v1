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

    public function getByCode($code) {
        switch ($code) {
            case "PLAN":return $this->getPlans();
            case "USERS":return $this->getUsers();
            case "CATEGORY":return $this->getCategory();
            case "USER_NAME":return $this->getUserNameList();
            case "COUNTRY":return $this->getCountries();
            case "USER_STATUS":return $this->getUserStatus();
            default :"Invalid Dropdown code ";
        }
    }

    private function getPlans() {
        $plans = $this->daoFactory->getPlanDAO()->findAll();
        $items = $this->getArrayWithEmpyItem();
        foreach ($plans as $plan) {
            $model = new KeyValue($plan->getId(), $plan->getName() . " -- " . $plan->getPrice() . " INR" . "-- BV " . $plan->getBusinessVolume());
            array_push($items, $model);
        }
        return $items;
    }

    private function getUsers() {
        $users = $this->daoFactory->getUserDAO()->findAll();
        $items = $this->getArrayWithEmpyItem();
        foreach ($users as $user) {
            $model = new KeyValue($user->getId(), $user->getUserName());
            array_push($items, $model);
        }
        return $items;
    }

    private function getUserNameList() {
        $users = $this->daoFactory->getUserDAO()->findAll();
        $items = $this->getArrayWithEmpyItem();
        foreach ($users as $user) {
            $model = new KeyValue($user->getUserName(), $user->getUserName());
            array_push($items, $model);
        }
        return $items;
    }

    private function getUserStatus() {
        $statusList = array();
        array_push($statusList, new KeyValue(StatusType::USER_ACTIVE, "ACTIVETED USER"));
        array_push($statusList, new KeyValue(StatusType::USER_DEACTIVE, "BLOCKED USER"));
        array_push($statusList, new KeyValue(StatusType::NEW_USER, "NEW USER"));
        return $statusList;
    }

    private function getCategory() {
        $list = array();
        array_push($list, new KeyValue("banner", "banner"));
        array_push($list, new KeyValue("gallary", "gallary"));
	    array_push($list, new KeyValue("legal", "legal"));
        return $list;
    }

    private function getCountries() {
        $codeTypeCountry = $this->daoFactory->getCodeTypeDAO()->getByCode("COUNTRY");
        $items = $this->getArrayWithEmpyItem();
        foreach ($codeTypeCountry->getGenericCodes() as $country) {
            $model = new KeyValue($country->getCode(), $country->getDescription());
            array_push($items, $model);
        }
        return $items;
    }

    private function getArrayWithEmpyItem() {
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
