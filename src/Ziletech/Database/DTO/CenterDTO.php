<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\Center;

class CenterDTO {

    /**
     * @var integer
     */
    public $centerId;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $blockName;

    /**
     * @var string
     */
    public $districtName;

    /**
     * @var string
     */
    public $feeType;

    /**
     * @var string
     */
    public $from;

    /**
     * @var string
     */
    public $to;

    /**
     * @var integer
     */
    public $lat;

    /**
     * @var integer
     */
    public $long;

    /**
     * @var integer
     */
    public $pinCode;

    /**
     * @var string
     */
    public $stateName;

    /**
     * @var SessionDTO[]
     */
    public $sessions = [];

    public function __construct(Center $center = null) {
        if (isset($center)) {
            $this->copyFromDomain($center);
        }
    }

    /**
     * @param Center $center
     */
    public function copyFromDomain(Center $center) {
        $this->centerId = $center->getCenterId();
        $this->name = $center->getName();
        $this->address = $center->getAddress();
        $this->blockName = $center->getBlockName();
        $this->districtName = $center->getDistrictName();
        $this->feeType = $center->getFeeType();
        $this->from = $center->getFrom();
        $this->to = $center->getTo();
        $this->lat = $center->getLat();
        $this->long = $center->getLong();
        $this->pinCode = $center->getPinCode();
        $this->stateName = $center->getStateName();
    }

    public function copyToDomain(Center $center) {
        $center->setCenterId($this->centerId);
        $center->setName($this->name);
        $center->setAddress($this->address);
        $center->setBlockName($this->blockName);
        $center->setDistrictName($this->districtName);
        $center->setFeeType($this->feeType);
        $center->setFrom($this->from);
        $center->setTo($this->to);
        $center->setLat($this->lat);
        $center->setLong($this->long);
        $center->setPinCode($this->pinCode);
        $center->setStateName($this->stateName);
    }

    /**
     * @return int
     */
    public function getCenterId(): int {
        return $this->centerId;
    }

    /**
     * @param int $centerId
     */
    public function setCenterId(int $centerId): void {
        $this->centerId = $centerId;
    }

    /**
     * @return string
     */
    public function getAddress(): string {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getBlockName(): string {
        return $this->blockName;
    }

    /**
     * @param string $blockName
     */
    public function setBlockName(string $blockName): void {
        $this->blockName = $blockName;
    }

    /**
     * @return string
     */
    public function getDistrictName(): string {
        return $this->districtName;
    }

    /**
     * @param string $districtName
     */
    public function setDistrictName(string $districtName): void {
        $this->districtName = $districtName;
    }

    /**
     * @return string
     */
    public function getFeeType(): string {
        return $this->feeType;
    }

    /**
     * @param string $feeType
     */
    public function setFeeType(string $feeType): void {
        $this->feeType = $feeType;
    }

    /**
     * @return string
     */
    public function getFrom(): string {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getTo(): string {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to): void {
        $this->to = $to;
    }

    /**
     * @return int
     */
    public function getLat(): int {
        return $this->lat;
    }

    /**
     * @param int $lat
     */
    public function setLat(int $lat): void {
        $this->lat = $lat;
    }

    /**
     * @return int
     */
    public function getLong(): int {
        return $this->long;
    }

    /**
     * @param int $long
     */
    public function setLong(int $long): void {
        $this->long = $long;
    }

    /**
     * @return int
     */
    public function getPinCode(): int {
        return $this->pinCode;
    }

    /**
     * @param int $pinCode
     */
    public function setPinCode(int $pinCode): void {
        $this->pinCode = $pinCode;
    }

    /**
     * @return string
     */
    public function getStateName(): string {
        return $this->stateName;
    }

    /**
     * @param string $stateName
     */
    public function setStateName(string $stateName): void {
        $this->stateName = $stateName;
    }

    /**
     * @return array
     */
    public function getSessions(): array {
        return $this->sessions;
    }

    /**
     * @param array $sessions
     */
    public function setSessions(array $sessions): void {
        $this->sessions = $sessions;
    }

}
