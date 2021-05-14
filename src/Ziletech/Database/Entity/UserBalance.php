<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="user_balance")
 * */
class UserBalance extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /** @Column(type="decimal", name="balance") * */
    protected $balance;
    
    /** @Column(type="decimal", name="business_volumn") * */
    protected $businessVolume;
    
    /** @Column(type="decimal", name="team_business_volumn") * */
    protected $teamBusinessVolume;

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

    function getBalance() {
        return $this->balance;
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

    function setBalance($balance) {
        $this->balance = $balance;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function getBusinessVolume() {
        return $this->businessVolume;
    }

    function getTeamBusinessVolume() {
        return $this->teamBusinessVolume;
    }

    function setBusinessVolume($businessVolume) {
        $this->businessVolume = $businessVolume;
    }

    function setTeamBusinessVolume($teamBusinessVolume) {
        $this->teamBusinessVolume = $teamBusinessVolume;
    }

}
