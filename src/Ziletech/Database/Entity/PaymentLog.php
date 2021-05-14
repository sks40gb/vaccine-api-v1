<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="payment")
 * */
class PaymentLog extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="member_id", referencedColumnName="id")
     */
    protected $member;

    /**
     * @ManyToOne(targetEntity="PaymentMethod")
     * @JoinColumn(name="payment_type", referencedColumnName="id")
     */
    protected $paymentType;

    /** @Column(type="string", name="custom") * */
    protected $custom;

    /** @Column(type="decimal", name="amount") * */
    protected $amount;

    /** @Column(type="decimal", name="charge") * */
    protected $charge;

    /** @Column(type="decimal", name="net_amount") * */
    protected $netAmount;

    /** @Column(type="decimal", name="usd") * */
    protected $usd;

    /** @Column(type="decimal", name="btc_amo") * */
    protected $btcAmount;

    /** @Column(type="string", name="btc_acc") * */
    protected $btcAccount;

    /** @Column(type="integer", name="status") * */
    protected $status;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") * */
    protected $updatedAt;

    function __construct() {
        $this->status = 0;
    }

    function getId() {
        return $this->id;
    }

    function getMember() {
        return $this->member;
    }

    function getPaymentType() {
        return $this->paymentType;
    }

    function getCustom() {
        return $this->custom;
    }

    function getAmount() {
        return $this->amount;
    }

    function getCharge() {
        return $this->charge;
    }

    function getNetAmount() {
        return $this->netAmount;
    }

    function getUsd() {
        return $this->usd;
    }

    function getBtcAmount() {
        return $this->btcAmount;
    }

    function getBtcAccount() {
        return $this->btcAccount;
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

    function setMember($member) {
        $this->member = $member;
    }

    function setPaymentType($paymentType) {
        $this->paymentType = $paymentType;
    }

    function setCustom($custom) {
        $this->custom = $custom;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setCharge($charge) {
        $this->charge = $charge;
    }

    function setNetAmount($netAmount) {
        $this->netAmount = $netAmount;
    }

    function setUsd($usd) {
        $this->usd = $usd;
    }

    function setBtcAmount($btcAmount) {
        $this->btcAmount = $btcAmount;
    }

    function setBtcAccount($btcAccount) {
        $this->btcAccount = $btcAccount;
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

}
