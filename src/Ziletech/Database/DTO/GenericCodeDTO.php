<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\GenericCode;

class GenericCodeDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $remarks;

    /**
     * @var integer
     */
    public $index;

    /**
     * @var string
     */
    public $field1;

    /**
     * @var string
     */
    public $field2;

    /**
     * @var string
     */
    public $field3;

    /**
     * @var string
     */
    public $field4;

    /**
     * @var string
     */
    public $field5;

    /**
     * @var boolean
     */
    public $defaults;

    /**
     * @var boolean
     */
    public $enabled;

    /**
     *
     * @var CodeTypeDTO
     */
    public $codeType;

    public function __construct(GenericCode $genericCode = null) {
        if (isset($genericCode)) {
            $this->copyFromDomain($genericCode);
        }
    }

    public function copyFromDomain($genericCode) {
        $this->id = $genericCode->id;
        $this->code = $genericCode->code;
        $this->remarks = $genericCode->remarks;
        $this->description = $genericCode->description;
        $this->index = $genericCode->index;
        $this->field1 = $genericCode->field1;
        $this->field2 = $genericCode->field2;
        $this->field3 = $genericCode->field3;
        $this->field4 = $genericCode->field4;
        $this->field5 = $genericCode->field5;
        $this->defaults = $genericCode->defaults;
        $this->enabled = $genericCode->enabled;
    }

    public function copyToDomain($genericCode) {
        $genericCode->id = $this->id;
        $genericCode->code = $this->code;
        $genericCode->remarks = $this->remarks;
        $genericCode->description = $this->description;
        $genericCode->index = $this->index;
        $genericCode->field1 = $this->field1;
        $genericCode->field2 = $this->field2;
        $genericCode->field3 = $this->field3;
        $genericCode->field4 = $this->field4;
        $genericCode->field5 = $this->field5;
        $genericCode->defaults = $this->defaults;
        $genericCode->enabled = $this->enabled;
    }

    function getId() {
        return $this->id;
    }

    function getCode() {
        return $this->code;
    }

    function getDescription() {
        return $this->description;
    }

    function getRemarks() {
        return $this->remarks;
    }

    function getIndex() {
        return $this->index;
    }

    function getField1() {
        return $this->field1;
    }

    function getField2() {
        return $this->field2;
    }

    function getField3() {
        return $this->field3;
    }

    function getField4() {
        return $this->field4;
    }

    function getField5() {
        return $this->field5;
    }

    function getCodeType(): CodeTypeDTO {
        return $this->codeType;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setRemarks($remarks) {
        $this->remarks = $remarks;
    }

    function setIndex($index) {
        $this->index = $index;
    }

    function setField1($field1) {
        $this->field1 = $field1;
    }

    function setField2($field2) {
        $this->field2 = $field2;
    }

    function setField3($field3) {
        $this->field3 = $field3;
    }

    function setField4($field4) {
        $this->field4 = $field4;
    }

    function setField5($field5) {
        $this->field5 = $field5;
    }

    function setCodeType(CodeTypeDTO $codeType = null) {
        $this->codeType = $codeType;
    }

    function getDefaults() {
        return $this->defaults;
    }

    function setDefaults($defaults) {
        $this->defaults = $defaults;
    }

    function getEnabled() {
        return $this->enabled;
    }

    function setEnabled($enabled) {
        $this->enabled = $enabled;
    }

}
