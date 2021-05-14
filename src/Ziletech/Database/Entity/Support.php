<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="support")
 * */
class Support extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /** @Column(type="string", name="subject") * */
    protected $subject;

    /** @Column(type="string", name="ticket_number") * */
    protected $ticketNumber;

    /** @Column(type="integer", name="status") * */
    protected $status;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") * */
    protected $updatedAt;

    /**
     * @OneToMany(targetEntity="SupportMessage", mappedBy="support" , orphanRemoval=true)
     */
    protected $supportMessagesList;

    function __construct() {}

    function getId() {
        return $this->id;
    }

    function getUser() {
        return $this->user;
    }

    function getSubject() {
        return $this->subject;
    }

    function getTicketNumber() {
        return $this->ticketNumber;
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

    function getSupportMessagesList() {
        return $this->supportMessagesList;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

    function setTicketNumber($ticketNumber) {
        $this->ticketNumber = $ticketNumber;
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

    function setSupportMessagesList($supportMessagesList) {
        $this->supportMessagesList = $supportMessagesList;
    }

}
