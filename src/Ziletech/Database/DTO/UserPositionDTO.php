<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\UserPosition;

class UserPositionDTO extends BaseDTO {

    public $id;

    /**
     *
     * @var UserDTO
     */
    protected $userTree;

    /**
     *
     * @var integer
     */
    protected $position;

    /**
     *
     * @var integer
     */
    protected $count;

    public function __construct(UserPosition $userPosition = null) {
        if (isset($userPosition)) {
            $this->copyFromDomain($userPosition);
        }
    }

    public function copyFromDomain(UserPosition $userPosition) {
        $this->id = $userPosition->getId();
        $this->position = $userPosition->getPosition();
        $this->count = $userPosition->getCount();
    }

    public function copyToDomain(UserPosition $userTree) {
        $userTree->setId($this->id);
        $userTree->setPosition($this->position);
        $userTree->setCount($this->count);
    }

    function getId() {
        return $this->id;
    }

    function getUser(): UserDTO {
        return $this->user;
    }

    function getParent(): UserPositionDTO {
        return $this->parent;
    }

    function getLeftCount() {
        return $this->leftCount;
    }

    function getRightCount() {
        return $this->rightCount;
    }

    function getPosition() {
        return $this->position;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUser(UserDTO $user) {
        $this->user = $user;
    }

    function setParent(UserPositionDTO $parent) {
        $this->parent = $parent;
    }

    function setLeftCount($leftCount) {
        $this->leftCount = $leftCount;
    }

    function setRightCount($rightCount) {
        $this->rightCount = $rightCount;
    }

    function getOwner(): UserPositionDTO {
        return $this->owner;
    }

    function setOwner(UserPositionDTO $owner) {
        $this->owner = $owner;
    }

    function setPosition($position) {
        $this->position = $position;
    }

}
