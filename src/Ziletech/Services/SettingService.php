<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Exceptions\ZiletechException;

class SettingService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function getSetting($type) {
        $codeType = $this->daoFactory->getCodeTypeDAO()->getByCode($type);
        if ($codeType == null) {
            throw new ZiletechException("Code Type $type does not exist.");
        }
        $properties = array();
        foreach ($codeType->getGenericCodes() as $gc) {
            $code = $gc->getCode();
            $properties[$code] = array();
            $properties[$code]["property"] = $gc->getDescription();
            $properties[$code][$codeType->getLabel1()] = $gc->getField1();
            $properties[$code][$codeType->getLabel2()] = $gc->getField2();
            $properties[$code][$codeType->getLabel3()] = $gc->getField3();
            $properties[$code][$codeType->getLabel4()] = $gc->getField4();
            $properties[$code][$codeType->getLabel5()] = $gc->getField5();
            $properties[$code][$codeType->getLabel6()] = $gc->getEnabled();
        }
        return $properties;
    }

    public function updateSetting($type, $settings) {
        foreach ($settings as $name => $value) {
            $property = $this->daoFactory->getGenericCodeDAO()->getByCodeTypeAndCode($type, $name);
            if ($property == null) {
                throw new ZiletechException("Generic code with code type $type and code $name does not exists");
            }
            $codeType = $property->getCodeType();


            if (isset($value->property)) {
                $property->setDescription($value->property);
            }

            if (isset($value->{$codeType->getLabel1()})) {
                $property->setField1($value->{$codeType->getLabel1()});
            }
            if (isset($value->{$codeType->getLabel2()})) {
                $property->setField2($value->{$codeType->getLabel2()});
            }
            if (isset($value->{$codeType->getLabel3()})) {
                $property->setField3($value->{$codeType->getLabel3()});
            }
            if (isset($value->{$codeType->getLabel4()})) {
                $property->setField4($value->{$codeType->getLabel4()});
            }
            if (isset($value->{$codeType->getLabel5()})) {
                $property->setField5($value->{$codeType->getLabel5()});
            }
            if (isset($value->{$codeType->getLabel6()})) {
                $property->setEnabled($value->{$codeType->getLabel6()});
            }
            $this->daoFactory->getGenericCodeDAO()->update($property);
        }
        return $settings;
    }

}
