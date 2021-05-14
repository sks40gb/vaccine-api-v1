<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="testimonials")
 * */
class Testimonial extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="name") * */
    protected $name;

    /** @Column(type="string", name="position") * */
    protected $position;

    /** @Column(type="string", name="message") * */
    protected $message;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") * */
    protected $updatedAt;

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

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
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

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

}
