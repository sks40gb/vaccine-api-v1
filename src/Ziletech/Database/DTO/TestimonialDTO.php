<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\Testimonial;

class TestimonialDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $position;

    /**
     * @var string
     */
    public $message;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var DateTime
     */
    public $updatedAt;

    public function __construct(Testimonial $testimonial = null) {
        if (isset($testimonial)) {
            $this->copyFromDomain($testimonial);
        }
    }

    public function copyFromDomain($testimonial) {
        $this->id = $testimonial->id;
        $this->name = $testimonial->name;
        $this->position = $testimonial->position;
        $this->message = $testimonial->message;
        $this->createdAt = $testimonial->createdAt;
        $this->updatedAt = $testimonial->updatedAt;
    }

    public function copyToDomain($testimonial) {
        $testimonial->id = $this->id;
        $testimonial->name = $this->name;
        $testimonial->position = $this->position;
        $testimonial->message = $this->message;
        $testimonial->createdAt = $this->createdAt;
        $testimonial->updatedAt = $this->updatedAt;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getPosition() {
        return $this->position;
    }

    function getMessage() {
        return $this->message;
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

    function setPosition($position) {
        $this->position = $position;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

}
