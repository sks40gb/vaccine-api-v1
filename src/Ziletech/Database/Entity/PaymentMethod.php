<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="payment_method")
 * */
class PaymentMethod extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="name") * */
    protected $name;

    /** @Column(type="string", name="val1") * */
    protected $description;

    /** @Column(type="string", name="val2") * */
    protected $value;

    /** @Column(type="string", name="currency") * */
    protected $currency;

    /** @Column(type="integer", name="status") * */
    protected $status;

    /** @Column(type="decimal", name="rate") * */
    protected $rate;

    /** @Column(type="decimal", name="fix") * */
    protected $fix;

    /** @Column(type="decimal", name="percent") * */
    protected $percent;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") * */
    protected $updatedAt;

    /**
     * @OneToMany(targetEntity="Deposit", mappedBy="paymentType" , orphanRemoval=true)
     */
    protected $depositList;

    /**
     * @OneToMany(targetEntity="PaymentLog", mappedBy="paymentType" , orphanRemoval=true)
     */
    protected $paymentLogList;
    
     /**
     * @ManyToOne(targetEntity="File")
     * @JoinColumn(name="image", referencedColumnName="id")
     */
    protected $image;

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getValue() {
        return $this->value;
    }

    function getCurrency() {
        return $this->currency;
    }

    function getStatus() {
        return $this->status;
    }

    function getRate() {
        return $this->rate;
    }

    function getFix() {
        return $this->fix;
    }

    function getPercent() {
        return $this->percent;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function getDepositList() {
        return $this->depositList;
    }

    function getPaymentLogList() {
        return $this->paymentLogList;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setValue($value) {
        $this->value = $value;
    }

    function setCurrency($currency) {
        $this->currency = $currency;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setRate($rate) {
        $this->rate = $rate;
    }

    function setFix($fix) {
        $this->fix = $fix;
    }

    function setPercent($percent) {
        $this->percent = $percent;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setDepositList($depositList) {
        $this->depositList = $depositList;
    }

    function setPaymentLogList($paymentLogList) {
        $this->paymentLogList = $paymentLogList;
    }
    
    function getImage() {
        return $this->image;
    }

    function setImage($image) {
        $this->image = $image;
    }

}
