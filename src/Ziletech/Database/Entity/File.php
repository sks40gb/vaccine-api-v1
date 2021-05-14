<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="file")
 * */
class File extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="name") * */
    protected $name;

    /** @Column(type="string", name="content_type") * */
    protected $contentType;

    /** @Column(type="boolean", name="is_directory") * */
    protected $directory;

    /** @Column(type="blob", name="data") * */
    protected $data;

    /** @Column(type="datetime", name="created_at", nullable=true) */
    protected $createdAt;

    /** @Column(type="integer", name="`size`", nullable=true) */
    private $size;

    /**
     * @ManyToOne(targetEntity="user")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    function __construct() {
        $this->directory = false;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getContentType() {
        return $this->contentType;
    }

    function getDirectory() {
        return $this->directory;
    }

    function getData() {
        return $this->data;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUser() {
        return $this->user;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setContentType($contentType) {
        $this->contentType = $contentType;
    }

    function setDirectory($directory) {
        $this->directory = $directory;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUser($user) {
        $this->user = $user;
    }
    
    function getSize() {
        return $this->size;
    }

    function setSize($size) {
        $this->size = $size;
    }

}
