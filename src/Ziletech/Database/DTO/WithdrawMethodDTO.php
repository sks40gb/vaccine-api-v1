<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\WithdrawMethod;
use Ziletech\Util\DateUtil;

class WithdrawMethodDTO extends BaseDTO {

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
    public $withdrawMin;
    public $withdrawMax;
    public $fix;
    public $percent;

    /**
     * @var string
     */
    public $duration;

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
    public $withdrawLogsList = [];

    public function __construct(WithdrawMethod $withdrawMethod = null) {
        if (isset($withdrawMethod)) {
            $this->copyFromDomain($withdrawMethod);
        }
    }

    public function copyFromDomain($withdrawMethod) {
        $this->id = $withdrawMethod->id;
        $this->name = $withdrawMethod->name;
        $this->withdrawMin = $withdrawMethod->withdrawMin;
        $this->withdrawMax = $withdrawMethod->withdrawMax;
        $this->fix = $withdrawMethod->fix;
        $this->percent = $withdrawMethod->percent;
        $this->duration = $withdrawMethod->duration;
        $this->status = $withdrawMethod->status;
        $this->createdAt = $withdrawMethod->createdAt;
        $this->updatedAt = $withdrawMethod->updatedAt;
    }

    public function copyToDomain($withdrawMethod) {
        $withdrawMethod->id = $this->id;
        $withdrawMethod->name = $this->name;
        $withdrawMethod->withdrawMin = $this->withdrawMin;
        $withdrawMethod->withdrawMax = $this->withdrawMax;
        $withdrawMethod->fix = $this->fix;
        $withdrawMethod->percent = $this->percent;
        $withdrawMethod->duration = $this->duration;
        $withdrawMethod->status = $this->status;
        $withdrawMethod->createdAt = $this->createdAt;
        $withdrawMethod->updatedAt = $this->updatedAt;
    }

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

    function getWithdrawMax() {
        return $this->withdrawMax;
    }

    function getFix() {
        return $this->fix;
    }

    function getPercent() {
        return $this->percent;
    }

    function getDuration() {
        return $this->duration;
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

    function setImage($image) {
        $this->image = $image;
    }

    function setWithdrawMin($withdrawMin) {
        $this->withdrawMin = $withdrawMin;
    }

    function setWithdrawMax($withdrawMax) {
        $this->withdrawMax = $withdrawMax;
    }

    function setFix($fix) {
        $this->fix = $fix;
    }

    function setPercent($percent) {
        $this->percent = $percent;
    }

    function setDuration($duration) {
        $this->duration = $duration;
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

}
