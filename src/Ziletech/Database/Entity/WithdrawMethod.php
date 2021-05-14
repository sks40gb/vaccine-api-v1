<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="withdraw_method")
 * */
class WithdrawMethod extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="name") * */
    protected $name;

    /** @Column(type="decimal", name="withdraw_min") * */
    protected $withdrawMin;

    /** @Column(type="decimal", name="percent") * */
    protected $percent;

    /** @Column(type="decimal", name="withdraw_max") * */
    protected $withdrawMax;

    /** @Column(type="decimal", name="fix") * */
    protected $fix;

    /** @Column(type="string", name="duration") * */
    protected $duration;

    /** @Column(type="boolean", name="status") * */
    protected $status;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") * */
    protected $updatedAt;

    /**
     * @OneToMany(targetEntity="Withdraw", mappedBy="withdrawLog" , orphanRemoval=true)
     */
    protected $withdrawLogsList;

    /**
     * @ManyToOne(targetEntity="File")
     * @JoinColumn(name="image", referencedColumnName="id")
     */
    protected $image;

    function __construct() {}

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getImage() {
        return $this->image;
    }

    function getWithdrawMin() {
        return $this->withdrawMin;
    }

    function getPercent() {
        return $this->percent;
    }

    function getWithdrawMax() {
        return $this->withdrawMax;
    }

    function getFix() {
        return $this->fix;
    }

    function getDuration() {
        return $this->duration;
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

    function getWithdrawLogsList() {
        return $this->withdrawLogsList;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setWithdrawMin($withdrawMin) {
        $this->withdrawMin = $withdrawMin;
    }

    function setPercent($percent) {
        $this->percent = $percent;
    }

    function setWithdrawMax($withdrawMax) {
        $this->withdrawMax = $withdrawMax;
    }

    function setFix($fix) {
        $this->fix = $fix;
    }

    function setDuration($duration) {
        $this->duration = $duration;
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

    function setWithdrawLogsList($withdrawLogsList) {
        $this->withdrawLogsList = $withdrawLogsList;
    }

}
