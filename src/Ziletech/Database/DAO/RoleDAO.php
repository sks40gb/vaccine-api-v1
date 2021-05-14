<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\Role;

class RoleDAO extends BaseDAO{

    public function __construct($entityManager) {
         parent::__construct($entityManager, Role::class);
    }
    
      public function getByName($name): Role {
        return $this->get(["name" => $name]);
    }

}
