<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\File;

class FileDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var boolean
     */
    public $directory;

    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @var string
     */
    public $contentType;

    /**
     * @var UserDTO
     */
    public $user;

    public function __construct(File $file = null) {
        if (isset($file)) {
            $this->copyFromDomain($file);
        }
    }

    public function copyFromDomain($file) {
        $this->id = $file->getId();
        $this->name = $file->getName();
        $this->directory = $file->getDirectory();
        $this->createdAt = $file->getCreatedAt();
        $this->contentType = $file->getContentType();
    }

    public function copyToDomain($file) {
        $file->setId($this->id);
        $file->setName($this->name);
        $file->setDirectory($this->directory);
        $file->setCreatedAt($this->createdAt);
        $file->setContentType($this->contentType);
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getDirectory() {
        return $this->directory;
    }

    function getCreatedAt(): \DateTime {
        return $this->createdAt;
    }

    function getContentType() {
        return $this->contentType;
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

    function setDirectory($directory) {
        $this->directory = $directory;
    }

    function setCreatedAt(\DateTime $createdAt = null) {
        $this->createdAt = $createdAt;
    }

    function setContentType($contentType) {
        $this->contentType = $contentType;
    }

    function setUser($user) {
        $this->user = $user;
    }

}
