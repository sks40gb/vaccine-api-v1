<?php

namespace Ziletech\Database\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="code_type")
 * */
class CodeType extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="description") * */
    protected $description;

    /** @Column(type="string", name="label1") * */
    protected $label1;

    /** @Column(type="string", name="label2") * */
    protected $label2;

    /** @Column(type="string", name="label3") * */
    protected $label3;

    /** @Column(type="string", name="label4") * */
    protected $label4;

    /** @Column(type="string", name="label5") * */
    protected $label5;

    /** @Column(type="string", name="label6") * */
    protected $label6;

    /**
     * @OneToMany(targetEntity="GenericCode", mappedBy="codeType", orphanRemoval=true)
     */
    protected $genericCodes;

    public function __construct() {
        $this->genericCodes = new ArrayCollection();
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

class CodeTypeConstant {

    const SETTING = "SETTING";
    const EMAIL_TEMPLATE = "EMAIL_TEMPLATE";
    const PDF_TEMPLATE = "PDF_TEMPLATE";
    const EMAIL_CONFIG = "EMAIL_CONFIG";
    const SMS_CONFIG = "SMS_CONFIG";
    const SMS_NOTIFICATION = "SMS_NOTIFICATION";

}
