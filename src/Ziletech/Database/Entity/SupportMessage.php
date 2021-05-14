<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="support_message")
 * */
class SupportMessage extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Support")
     * @JoinColumn(name="support_id", referencedColumnName="id")
     */
    protected $support;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /** @Column(type="string", name="ticket_number") * */
    protected $ticketNumber;

    /** @Column(type="string", name="message") * */
    protected $message;

    /** @Column(type="integer", name="type") * */
    protected $type;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") * */
    protected $updatedAt;

    function __construct() {}

    function getId() {
        return $this->id;
    }

    function getSupport() {
        return $this->support;
    }

    function getTicketNumber() {
        return $this->ticketNumber;
    }

    function getMessage() {
        return $this->message;
    }

    function getType() {
        return $this->type;
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

    function setSupport($support) {
        $this->support = $support;
    }

    function setTicketNumber($ticketNumber) {
        $this->ticketNumber = $ticketNumber;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function getUser() {
        return $this->user;
    }

    function setUser($user) {
        $this->user = $user;
    }

}
