<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="plan")
 * */
class Plan extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="name") * */
    protected $name;

    /** @Column(type="decimal", name="price") * */
    protected $price;

    /** @Column(type="decimal", name="installment_price") * */
    protected $installmentPrice;

    /** @Column(type="decimal", name="business_volume") * */
    protected $businessVolume;

    /** @Column(type="decimal", name="level1") * */
    protected $firstLevel;

    /** @Column(type="decimal", name="level2") * */
    protected $secondLevel;

    /** @Column(type="decimal", name="reference") * */
    protected $reference;

    /** @Column(type="integer", name="status") * */
    protected $status;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") * */
    protected $updatedAt;

    /**
     * @ManyToOne(targetEntity="File")
     * @JoinColumn(name="image", referencedColumnName="id")
     */
    protected $image;

    function __construct() {
        
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

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
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

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt) {
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

    function getImage() {
        return $this->image;
    }

    function setImage($image) {
        $this->image = $image;
    }

}
