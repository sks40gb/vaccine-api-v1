<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\Plan;

class PlanDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;
    public $price;
    public $firstLevel;
    public $secondLevel;
    public $reference;
    public $installmentPrice;
    public $businessVolume;

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

    /**
     * @var FileDTO
     */
    public $image;

    public function __construct(Plan $plan = null) {
        if (isset($plan)) {
            $this->copyFromDomain($plan);
        }
    }

    public function copyFromDomain($plan) {
        $this->id = $plan->id;
        $this->name = $plan->name;
        $this->price = $plan->price;
        $this->installmentPrice = $plan->installmentPrice;
        $this->firstLevel = $plan->firstLevel;
        $this->secondLevel = $plan->secondLevel;
        $this->reference = $plan->reference;
        $this->status = $plan->status;
        $this->businessVolume = $plan->businessVolume;
        $this->createdAt = $plan->createdAt;
        $this->updatedAt = $plan->updatedAt;
    }

    public function copyToDomain($plan) {
        $plan->id = $this->id;
        $plan->name = $this->name;
        $plan->price = $this->price;
        $plan->installmentPrice = $this->installmentPrice;
        $plan->firstLevel = $this->firstLevel;
        $plan->secondLevel = $this->secondLevel;
        $plan->reference = $this->reference;
        $plan->status = $this->status;
        $plan->businessVolume = $this->businessVolume;
        $plan->createdAt = $this->createdAt;
        $plan->updatedAt = $this->updatedAt;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getPrice() {
        return $this->price;
    }

    function getFirstLevel() {
        return $this->firstLevel;
    }

    function getSecondLevel() {
        return $this->secondLevel;
    }

    function getReference() {
        return $this->reference;
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

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setFirstLevel($firstLevel) {
        $this->firstLevel = $firstLevel;
    }

    function setSecondLevel($secondLevel) {
        $this->secondLevel = $secondLevel;
    }

    function setReference($reference) {
        $this->reference = $reference;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function getInstallmentPrice() {
        return $this->installmentPrice;
    }

    function setInstallmentPrice($installmentPrice) {
        $this->installmentPrice = $installmentPrice;
    }

    function getBusinessVolume() {
        return $this->businessVolume;
    }

    function setBusinessVolume($businessVolume) {
        $this->businessVolume = $businessVolume;
    }

    function getImage(): FileDTO {
        return $this->image;
    }

    function setImage(FileDTO $image) {
        $this->image = $image;
    }

}
