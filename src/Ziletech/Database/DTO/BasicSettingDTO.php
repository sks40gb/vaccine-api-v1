<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\Setting;

class BasicSettingDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;
    public $description;
    public $title;
    public $category;
    public $aboutUs;
    public $email;
    public $mobileNumber;
    public $address;

    /**
     *
     * @var FileDTO
     */
    public $image;

    public function __construct(Setting $setting = null) {
        if (isset($setting)) {
            $this->copyFromDomain($setting);
        }
    }

    public function copyFromDomain($setting) {
        $this->id = $setting->id;
        $this->description = $setting->description;
        $this->title = $setting->title;
        $this->category = $setting->category;
        $this->address = $setting->address;
        $this->mobileNumber = $setting->mobileNumber;
        $this->email = $setting->email;
        $this->aboutUs = $setting->aboutUs;
    }

    public function copyToDomain($setting) {
        $setting->id = $this->id;
        $setting->description = $this->description;
        $setting->title = $this->title;
        $setting->category = $this->category;
        $setting->address = $this->address;
        $setting->mobileNumber = $this->mobileNumber;
        $setting->email = $this->email;
        $setting->aboutUs = $this->aboutUs;
    }

    function getId() {
        return $this->id;
    }

    function getDescription() {
        return $this->description;
    }

    function getTitle() {
        return $this->title;
    }

    function getCategory() {
        return $this->category;
    }

    function getImage(): FileDTO {
        return $this->image;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setCategory($category) {
        $this->category = $category;
    }

    function setImage(FileDTO $image) {
        $this->image = $image;
    }

    function getAboutUs() {
        return $this->aboutUs;
    }

    function getEmail() {
        return $this->email;
    }

    function getMobileNumber() {
        return $this->mobileNumber;
    }

    function getAddress() {
        return $this->address;
    }

    function setAboutUs($aboutUs) {
        $this->aboutUs = $aboutUs;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setMobileNumber($mobileNumber) {
        $this->mobileNumber = $mobileNumber;
    }

    function setAddress($address) {
        $this->address = $address;
    }

}
