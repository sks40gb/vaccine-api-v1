<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="role")
 * */
class Role extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="name") * */
    protected $name;

    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

}

abstract class UserRole {
    const ADMIN_ROLE = "admin";
    const USER_ROLE = "user";

}