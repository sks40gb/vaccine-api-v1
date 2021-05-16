<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity
 * @Table(name="center")
 * */
class Center extends BaseEntity {

    /**
     * @Id
     * @Column(type="integer", name="center_id")
     */
    protected $centerId;

    /** @Column(type="string", name="address") * */
    protected $address;

    /** @Column(type="string", name="block_name") * */
    protected $blockName;

    /** @Column(type="string", name="district_name") * */
    protected $districtName;

    /** @Column(type="string", name="fee_type") * */
    protected $feeType;

    /** @Column(type="string", name="from") * */
    protected $from;

    /** @Column(type="string", name="to") * */
    protected $to;

    /** @Column(type="integer", name="lat") * */
    protected $lat;

    /** @Column(type="integer", name="long") * */
    protected $long;

    /** @Column(type="integer", name="pincode") * */
    protected $pinCode;

    /** @Column(type="string", name="state_name") * */
    protected $stateName;

    function __construct() {
    }

    /**
     * @return mixed
     */
    public function getCenterId() {
        return $this->centerId;
    }

    /**
     * @param mixed $centerId
     */
    public function setCenterId($centerId): void {
        $this->centerId = $centerId;
    }

    /**
     * @return mixed
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getBlockName() {
        return $this->blockName;
    }

    /**
     * @param mixed $blockName
     */
    public function setBlockName($blockName): void {
        $this->blockName = $blockName;
    }

    /**
     * @return mixed
     */
    public function getDistrictName() {
        return $this->districtName;
    }

    /**
     * @param mixed $districtName
     */
    public function setDistrictName($districtName): void {
        $this->districtName = $districtName;
    }

    /**
     * @return mixed
     */
    public function getFeeType() {
        return $this->feeType;
    }

    /**
     * @param mixed $feeType
     */
    public function setFeeType($feeType): void {
        $this->feeType = $feeType;
    }

    /**
     * @return mixed
     */
    public function getFrom() {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from): void {
        $this->from = $from;
    }

    /**
     * @return mixed
     */
    public function getTo() {
        return $this->to;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to): void {
        $this->to = $to;
    }

    /**
     * @return mixed
     */
    public function getLat() {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat): void {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLong() {
        return $this->long;
    }

    /**
     * @param mixed $long
     */
    public function setLong($long): void {
        $this->long = $long;
    }

    /**
     * @return mixed
     */
    public function getPinCode() {
        return $this->pinCode;
    }

    /**
     * @param mixed $pinCode
     */
    public function setPinCode($pinCode): void {
        $this->pinCode = $pinCode;
    }

    /**
     * @return mixed
     */
    public function getStateName() {
        return $this->stateName;
    }

    /**
     * @param mixed $stateName
     */
    public function setStateName($stateName): void {
        $this->stateName = $stateName;
    }


    public function __toString() {
        return "Center[id: $this->centerId]";
    }

}
