<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="setting")
 * */
class Setting extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="description") * */
    protected $description;

    /** @Column(type="string", name="title") * */
    protected $title;

    /** @Column(type="string", name="category") * */
    protected $category;

    /** @Column(type="string", name="address") * */
    protected $address;

    /** @Column(type="string", name="mobile_number") * */
    protected $mobileNumber;

    /** @Column(type="string", name="email") * */
    protected $email;

    /** @Column(type="string", name="about_us") * */
    protected $aboutUs;

    /**
     * @ManyToOne(targetEntity="File")
     * @JoinColumn(name="image", referencedColumnName="id")
     */
    protected $image;

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

    function getImage() {
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

    function setImage($image) {
        $this->image = $image;
    }

    function getAddress() {
        return $this->address;
    }

    function getMobileNumber() {
        return $this->mobileNumber;
    }

    function getEmail() {
        return $this->email;
    }

    function getAboutUs() {
        return $this->aboutUs;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setMobileNumber($mobileNumber) {
        $this->mobileNumber = $mobileNumber;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setAboutUs($aboutUs) {
        $this->aboutUs = $aboutUs;
    }

}
