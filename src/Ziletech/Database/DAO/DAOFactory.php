<?php

namespace Ziletech\Database\DAO;

class DAOFactory {

    // obtaining the entity manager
    private $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function getUserDAO(): UserDAO {
        return new UserDAO($this->entityManager);
    }

    public function getFileDAO(): FileDAO {
        return new FileDAO($this->entityManager);
    }

    public function getRoleDAO(): RoleDAO {
        return new RoleDAO($this->entityManager);
    }

    public function getCodeTypeDAO(): CodeTypeDAO {
        return new CodeTypeDAO($this->entityManager);
    }

    public function getGenericCodeDAO(): GenericCodeDAO {
        return new GenericCodeDAO($this->entityManager);
    }

}
