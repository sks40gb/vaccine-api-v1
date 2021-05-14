<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\PaymentMethod;

class PaymentMethodDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $image;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $value;

    /**
     * @var string
     */
    public $currency;
    public $rate;
    public $fix;
    public $percent;

    /**
     * @var integer
     */
    public $status;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var DateTime
     */
    public $updatedAt;
    public $depositList = [];
    public $paymentLogList = [];

    public function __construct(PaymentMethod $paymentMethod = null) {
        if (isset($paymentMethod)) {
            $this->copyFromDomain($paymentMethod);
        }
    }

    public function copyFromDomain($paymentMethod) {
        $this->id = $paymentMethod->id;
        $this->name = $paymentMethod->name;
        $this->rate = $paymentMethod->rate;
        $this->fix = $paymentMethod->fix;
        $this->percent = $paymentMethod->percent;
        $this->description = $paymentMethod->description;
        $this->value = $paymentMethod->value;
        $this->currency = $paymentMethod->currency;
        $this->status = $paymentMethod->status;
        $this->createdAt = $paymentMethod->createdAt;
        $this->updatedAt = $paymentMethod->updatedAt;
    }

    public function copyToDomain($paymentMethod) {
        $paymentMethod->id = $this->id;
        $paymentMethod->name = $this->name;
        $paymentMethod->rate = $this->rate;
        $paymentMethod->fix = $this->fix;
        $paymentMethod->percent = $this->percent;
        $paymentMethod->description = $this->description;
        $paymentMethod->value = $this->value;
        $paymentMethod->currency = $this->currency;
        $paymentMethod->status = $this->status;
        $paymentMethod->createdAt = $this->createdAt;
        $paymentMethod->updatedAt = $this->updatedAt;
    }

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

    function getRate() {
        return $this->rate;
    }

    function getFix() {
        return $this->fix;
    }

    function getPercent() {
        return $this->percent;
    }

    function getStatus() {
        return $this->status;
    }

    function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    function getUpdatedAt(): DateTime {
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

    function setRate($rate) {
        $this->rate = $rate;
    }

    function setFix($fix) {
        $this->fix = $fix;
    }

    function setPercent($percent) {
        $this->percent = $percent;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setCreatedAt(DateTime $createdAt = null) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(DateTime $updatedAt = null) {
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
