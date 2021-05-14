<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\Role;

class RoleDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    public function __construct(Role $role = null) {
        if (isset($role)) {
            $this->copyFromDomain($role);
        }
    }

    public function copyFromDomain($role) {
        $this->id = $role->getId();
        $this->name = $role->getName();
    }

    public function copyToDomain($role) {
        $role->id = $this->id;
        $role->name = $this->name;
    }

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
