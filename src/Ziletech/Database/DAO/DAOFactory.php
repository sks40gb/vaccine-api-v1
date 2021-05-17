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

    public function getGenericCodeDAO(): ExecutionTrackerDAO {
        return new ExecutionTrackerDAO($this->entityManager);
    }

    public function getCenterDAO(): CenterDAO {
        return new CenterDAO($this->entityManager);
    }

    public function getSessionDAO(): SessionDAO {
        return new SessionDAO($this->entityManager);
    }

    public function getSlotDAO(): SlotDAO {
        return new SlotDAO($this->entityManager);
    }

    public function getExecutionTrackerDAO(): ExecutionTrackerDAO {
        return new ExecutionTrackerDAO($this->entityManager);
    }

}
