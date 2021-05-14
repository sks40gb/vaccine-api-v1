<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="user_position")
 * */
class UserPosition extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @var UserTree
     * @ManyToOne(targetEntity="UserTree")
     * @JoinColumn(name="user_tree_id", referencedColumnName="id")
     */
    protected $userTree;

    /** @Column(type="integer", name="`position`") * */
    protected $position;

    /** @Column(type="integer", name="`count`") * */
    protected $count;

    function getId() {
        return $this->id;
    }

    function getUserTree(): UserTree {
        return $this->userTree;
    }

    function getPosition() {
        return $this->position;
    }

    function getCount() {
        return $this->count;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUserTree(UserTree $userTree) {
        $this->userTree = $userTree;
    }

    function setPosition($position) {
        $this->position = $position;
    }

    function setCount($count) {
        $this->count = $count;
    }

    public function __toString() {
        return "UserPosition[id: $this->id]";
    }

}
