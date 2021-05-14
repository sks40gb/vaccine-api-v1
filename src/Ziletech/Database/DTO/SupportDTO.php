<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\Support;

class SupportDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $ticketNumber;

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

    /**
     * @var UserDTO
     */
    public $user;
    public $supportMessagesList = [];

    public function __construct(Support $support = null) {
        if (isset($support)) {
            $this->copyFromDomain($support);
        }
    }

    public function copyFromDomain($support) {
        $this->id = $support->id;
        $this->subject = $support->subject;
        $this->ticketNumber = $support->ticketNumber;
        $this->status = $support->status;
        $this->createdAt = $support->createdAt;
        $this->updatedAt = $support->updatedAt;
    }

    public function copyToDomain($support) {
        $support->id = $this->id;
        $support->subject = $this->subject;
        $support->ticketNumber = $this->ticketNumber;
        $support->status = $this->status;
        $support->createdAt = $this->createdAt;
        $support->updatedAt = $this->updatedAt;
    }

    function getId() {
        return $this->id;
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

    function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    function getUser(): UserDTO {
        return $this->user;
    }

    function getSupportMessagesList() {
        return $this->supportMessagesList;
    }

    function setId($id) {
        $this->id = $id;
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

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setUser(UserDTO $user) {
        $this->user = $user;
    }

    function setSupportMessagesList($supportMessagesList) {
        $this->supportMessagesList = $supportMessagesList;
    }

}
