<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\CodeType;

class SessionDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $label1;

    /**
     * @var string
     */
    public $label2;

    /**
     * @var string
     */
    public $label3;

    /**
     * @var string
     */
    public $label4;

    /**
     * @var string
     */
    public $label5;

    /**
     * @var string
     */
    public $label6;
    protected $genericCodes = [];

    public function __construct(CodeType $codeType = null) {
        if (isset($codeType)) {
            $this->copyFromDomain($codeType);
        }
    }

    /**
     * 
     * @param type $codeType
     */
    public function copyFromDomain($codeType) {
        $this->id = $codeType->getId();
        $this->description = $codeType->getDescription();
        $this->label1 = $codeType->getLabel1();
        $this->label2 = $codeType->getLabel2();
        $this->label3 = $codeType->getLabel3();
        $this->label4 = $codeType->getLabel4();
        $this->label5 = $codeType->getLabel5();
        $this->label6 = $codeType->getLabel6();
    }

    public function copyToDomain($codeType) {
        $codeType->id = $this->id;
        $codeType->description = $this->description;
        $codeType->label1 = $this->label1;
        $codeType->label2 = $this->label2;
        $codeType->label3 = $this->label3;
        $codeType->label4 = $this->label4;
        $codeType->label5 = $this->label5;
        $codeType->label6 = $this->label6;
    }

    function getId() {
        return $this->id;
    }

    function getDescription() {
        return $this->description;
    }

    function getLabel1() {
        return $this->label1;
    }

    function getLabel2() {
        return $this->label2;
    }

    function getLabel3() {
        return $this->label3;
    }

    function getLabel4() {
        return $this->label4;
    }

    function getLabel5() {
        return $this->label5;
    }

    function getLabel6() {
        return $this->label6;
    }

    function getGenericCodes() {
        return $this->genericCodes;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setLabel1($label1) {
        $this->label1 = $label1;
    }

    function setLabel2($label2) {
        $this->label2 = $label2;
    }

    function setLabel3($label3) {
        $this->label3 = $label3;
    }

    function setLabel4($label4) {
        $this->label4 = $label4;
    }

    function setLabel5($label5) {
        $this->label5 = $label5;
    }

    function setLabel6($label6) {
        $this->label6 = $label6;
    }

    function setGenericCodes($genericCodes) {
        $this->genericCodes = $genericCodes;
    }

}
