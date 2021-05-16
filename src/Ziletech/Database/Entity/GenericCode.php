<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="generic_code")
 * */
class GenericCode extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    public $id;

    /** @Column(type="string", name="code") * */
    public $code;

    /** @Column(type="string", name="description") * */
    public $description;

    /** @Column(type="string", name="remarks") * */
    public $remarks;

    /** @Column(type="integer", name="`index`") * */
    public $index;

    /** @Column(type="string", name="field1") * */
    public $field1;

    /** @Column(type="string", name="field2") * */
    public $field2;

    /** @Column(type="string", name="field3") * */
    public $field3;

    /** @Column(type="string", name="field4") * */
    public $field4;

    /** @Column(type="string", name="field5") * */
    public $field5;

    /** @Column(type="boolean", name="enabled") * */
    public $enabled;

    /**
     * @ManyToOne(targetEntity="CodeType")
     * @JoinColumn(name="code_type_id", referencedColumnName="id")
     */
    public $codeType;

    /** @Column(type="boolean", name="defaults") * */
    public $defaults;

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

    function getCodeType() {
        return $this->codeType;
    }

    function getDefaults() {
        return $this->defaults;
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

    function setCodeType($codeType) {
        $this->codeType = $codeType;
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

class GenericCodeConstant {

    const REGISTER_EMAIL = "REGISTER_EMAIL";
    const USER_ACTIVE_EMAIL = "USER_ACTIVE_EMAIL";
    const REGISTER_SMS = "REGISTER_SMS";
    const USER_ACTIVE_SMS = "USER_ACTIVE_SMS";
    const RESET_PASSWORD = "RESET_PASSWORD";
    const HOST_NAME = "HOST_NAME";

}

abstract class Slack {

    const APP_SLACK_API = "APP_SLACK_API";
    const CODE = "SLACK_TEMPLATE";
    const SLACK_TEMPLATE_PUNCH_IN = "SLACK_TEMPLATE_PUNCH_IN";
    const SLACK_TEMPLATE_PUNCH_OUT = "SLACK_TEMPLATE_PUNCH_OUT";
    const SLACK_TEMPLATE_APPLIED_FOR_LEAVE = "SLACK_TEMPLATE_APPLIED_FOR_LEAVE";
    const SLACK_TEMPLATE_FOR_LEAVE_STATUS_CHANGE = "SLACK_TEMPLATE_FOR_LEAVE_STATUS_CHANGE";
    const SLACK_TEMPLATE_FOR_EXPENSE_STATUS_CHANGE = "SLACK_TEMPLATE_FOR_EXPENSE_STATUS_CHANGE";
    const SLACK_TEMPLATE_FOR_CREATED_EXPENSE = "SLACK_TEMPLATE_FOR_CREATED_EXPENSE";
    const SLACK_TEMPLATE_LATE_PUNCH_IN = "SLACK_TEMPLATE_LATE_PUNCH_IN";
    const SLACK_TEMPLATE_EMPLOYEE_ABSENSE = "SLACK_TEMPLATE_EMPLOYEE_ABSENSE";
    const SLACK_FORGOT_TO_PUNCH_OUT = "SLACK_FORGOT_TO_PUNCH_OUT";
    const SLACK_TEMPLATE_CREATE_BL_ENTRIES = "SLACK_TEMPLATE_CREATE_BL_ENTRIES";
    const SLACK_TEMPLATE_BL_ENTRIES_ASSIGN_TO_UPDATE = "SLACK_TEMPLATE_BL_ENTRIES_ASSIGN_TO_UPDATE";
    const SLACK_TEMPLATE_BL_ENTRIES_ASSIGN_TO_DEFAULT = "SLACK_TEMPLATE_BL_ENTRIES_ASSIGN_TO_DEFAULT";
    const SLACK_TEMPLATE_BL_ENTRIES_STAUS_UPDATE = "SLACK_TEMPLATE_BL_ENTRIES_STAUS_UPDATE";
    const SLACK_TEMPLATE_BL_ENTRY_COMMENT = "SLACK_TEMPLATE_BL_ENTRY_COMMENT";
    const SLACK_TEMPLATE_PENDING_ENTRY_TO_CONFIRM = "SLACK_TEMPLATE_PENDING_ENTRY_TO_CONFIRM";
    const SLACK_TEMPLATE_DELETE_MULTIPLE_BL_ENTRIES = "SLACK_TEMPLATE_DELETE_MULTIPLE_BL_ENTRIES";
    const SLACK_TEMPLATE_DELETE_BL_ENTRY = "SLACK_TEMPLATE_DELETE_BL_ENTRY";

}
