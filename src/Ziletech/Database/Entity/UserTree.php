<?php

namespace Ziletech\Database\Entity;

use Ziletech\Util\DateUtil;

/**
 * @Entity @Table(name="user_tree")
 * */
class UserTree extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @var User
     * @OneToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var User
     * @OneToOne(targetEntity="User")
     * @JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @var UserTree
     * @OneToOne(targetEntity="UserTree")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /** @Column(type="integer", name="`position`") * */
    protected $position;

    /** @Column(type="integer", name="`level`") * */
    protected $level;

    /** @Column(type="integer", name="`depth`") * */
    protected $depth;

    /** @Column(type="integer", name="`status`") * */
    protected $status;

    /** @Column(type="integer", name="`type`") * */
    protected $type = 0;

    /** @Column(type="datetime", name="completed_date") * */
    protected $completedDate;

    /** @Column(type="datetime", name="`created_date`") * */
    protected $createdAt;

    /**
     * @OneToMany(targetEntity="UserTree", mappedBy="parent", orphanRemoval=true)
     */
    protected $children;

    /**
     * @OneToMany(targetEntity="UserPosition", mappedBy="userTree", orphanRemoval=true)
     */
    protected $userPositions;

    function __construct() {
        $children = [];
        $this->status = 0;
        $this->level = 1;
    }

    function getId() {
        return $this->id;
    }

    function getUser(): User {
        return $this->user;
    }

    function getParent(): ?UserTree {
        return $this->parent;
    }

    function getOwner(): ?User {
        return $this->owner;
    }

    function setOwner(?User $owner) {
        $this->owner = $owner;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUser(?User $user) {
        $this->user = $user;
    }

    function setParent($parent) {
        $this->parent = $parent;
    }

    function getChildren() {
        return $this->children;
    }

    function setChildren($children) {
        $this->children = $children;
    }

    function getPosition() {
        return $this->position;
    }

    function setPosition($position) {
        $this->position = $position;
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

    public function __toString() {
        return "UserTree[id: $this->id]";
    }

    function getCompletedDate() {
        return $this->completedDate;
    }

    function setCompletedDate($completedDate) {
        $this->completedDate = $completedDate;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

}
