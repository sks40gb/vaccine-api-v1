<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\UserTree;

class UserTreeDTO extends BaseDTO {

    public $id;

    /**
     *
     * @var UserDTO
     */
    protected $user;

    /**
     *
     * @var UserDTO
     */
    protected $owner;

    /**
     *
     * @var UserTreeDTO
     */
    protected $parent;

    /**
     *
     * @var integer
     */
    protected $position;

    /**
     *
     * @var integer
     */
    protected $level;

    /**
     *
     * @var integer
     */
    protected $depth;

    /**
     *
     * @var integer
     */
    protected $status;

    /**
     *
     * @var integer
     */
    protected $type;

    /**
     *
     * @var DateTime
     */
    protected $completedDate;
    
     /**
     *
     * @var DateTime
     */
    protected $createdAt;
    /**
     *
     * @var array()
     */
    protected $children;

    /**
     *
     * @var array()
     */
    protected $userPositions;

    public function __construct(UserTree $userTree = null) {
        $this->children = array();
        $this->type = 0;
        if (isset($userTree)) {
            $this->copyFromDomain($userTree);
        }
    }

    public function copyFromDomain(UserTree $userTree) {
        $this->id = $userTree->getId();
        $this->position = $userTree->getPosition();
        $this->level = $userTree->getLevel();
        $this->depth = $userTree->getDepth();
        $this->status = $userTree->getStatus();
        $this->type = $userTree->getType();
        $this->completedDate = $userTree->getCompletedDate();
        $this->createdAt = $userTree->getCreatedAt();
    }

    public function copyToDomain(UserTree $userTree) {
        $userTree->setId($this->id);
        $userTree->setPosition($this->position);
        $userTree->setDepth($this->depth);
        $userTree->setStatus($this->status);
        $userTree->setType($this->type);
    }

    function getId() {
        return $this->id;
    }

    function getUser(): UserDTO {
        return $this->user;
    }

    function getParent(): UserTreeDTO {
        return $this->parent;
    }

    function getPosition() {
        return $this->position;
    }

    function getChildren() {
        return $this->children;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUser(UserDTO $user) {
        $this->user = $user;
    }

    function setParent(UserTreeDTO $parent) {
        $this->parent = $parent;
    }

    function getOwner(): UserDTO {
        return $this->owner;
    }

    function setOwner(UserDTO $owner) {
        $this->owner = $owner;
    }

    function setPosition($position) {
        $this->position = $position;
    }

    function setChildren($children) {
        $this->children = $children;
    }

    function getUserPositions() {
        return $this->userPositions;
    }

    function setUserPositions($userPositions) {
        $this->userPositions = $userPositions;
    }

    function getLevel() {
        return $this->level;
    }

    function setLevel($level) {
        $this->level = $level;
    }

    function getDepth() {
        return $this->depth;
    }

    function setDepth($depth) {
        $this->depth = $depth;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function getType() {
        return $this->type;
    }

    function setType($type) {
        $this->type = $type;
    }

    function getCompletedDate(): DateTime {
        return $this->completedDate;
    }

    function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    function setCompletedDate(DateTime $completedDate) {
        $this->completedDate = $completedDate;
    }

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }


}
