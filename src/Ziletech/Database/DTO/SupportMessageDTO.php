<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\SupportMessage;
use Ziletech\Util\DateUtil;

class SupportMessageDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $type;

    /**
     * @var string
     */
    public $ticketNumber;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $userName;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var DateTime
     */
    public $updatedAt;

    /**
     * @var SupportDTO
     */
    public $support;
    
      /**
     * @var UserDTO
     */
    public $user;

    public function __construct(SupportMessage $supportMessage = null) {
        if (isset($supportMessage)) {
            $this->copyFromDomain($supportMessage);
        }
    }

    public function copyFromDomain($supportMessage) {
        $this->id = $supportMessage->id;
        $this->ticketNumber = $supportMessage->ticketNumber;
        $this->message = $supportMessage->message;
        $this->type = $supportMessage->type;
        $this->createdAt = $supportMessage->createdAt;
        $this->updatedAt = $supportMessage->updatedAt;
    }

    public function copyToDomain($supportMessage) {
        $supportMessage->id = $this->id;
        $supportMessage->ticketNumber = $this->ticketNumber;
        $supportMessage->message = $this->message;
        $supportMessage->type = $this->type;
        $supportMessage->createdAt = $this->createdAt;
        $supportMessage->updatedAt = $this->updatedAt;
    }

    function getId() {
        return $this->id;
    }

    function getType() {
        return $this->type;
    }

    function getTicketNumber() {
        return $this->ticketNumber;
    }

    function getMessage() {
        return $this->message;
    }

    function getUserName() {
        return $this->userName;
    }

    function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    function getSupport(): SupportDTO {
        return $this->support;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setTicketNumber($ticketNumber) {
        $this->ticketNumber = $ticketNumber;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setSupport(SupportDTO $support) {
        $this->support = $support;
    }

    function getUser(): UserDTO {
        return $this->user;
    }

    function setUser(UserDTO $user) {
        $this->user = $user;
    }


}
