<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="user_login")
 * */
class UserLogin extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /** @Column(type="string", name="user_ip") * */
    protected $userIp;

    /** @Column(type="string", name="location") * */
    protected $location;

    /** @Column(type="string", name="details") * */
    protected $detail;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") * */
    protected $updatedAt;

    function getId() {
        return $this->id;
    }

    function getUser() {
        return $this->user;
    }

    function getUserIp() {
        return $this->userIp;
    }

    function getLocation() {
        return $this->location;
    }

    function getDetail() {
        return $this->detail;
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

    function setUser($user) {
        $this->user = $user;
    }

    function setUserIp($userIp) {
        $this->userIp = $userIp;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function setDetail($detail) {
        $this->detail = $detail;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

}
