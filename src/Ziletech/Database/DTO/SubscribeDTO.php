<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\Subscribe;

class SubscribeDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $email;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var DateTime
     */
    public $updatedAt;

    public function __construct(Subscribe $subscribe = null) {
        if (isset($subscribe)) {
            $this->copyFromDomain($subscribe);
        }
    }

    public function copyFromDomain($ubscribe) {
        $this->id = $ubscribe->id;
        $this->email = $ubscribe->email;
        $this->createdAt = $ubscribe->createdAt;
        $this->updatedAt = $ubscribe->updatedAt;
    }

    public function copyToDomain($subscribe) {
        $subscribe->id = $this->id;
        $subscribe->email = $this->email;
        $subscribe->createdAt = $this->createdAt;
        $subscribe->updatedAt = $this->updatedAt;
    }

    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
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

    function setEmail($email) {
        $this->email = $email;
    }

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

}
