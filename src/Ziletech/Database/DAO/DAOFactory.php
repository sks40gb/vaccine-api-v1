<?php

namespace Ziletech\Database\DAO;

class DAOFactory {

    // obtaining the entity manager
    private $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function getWithdrawLogDAO(): WithdrawLogDAO {
        return new WithdrawLogDAO($this->entityManager);
    }

    public function getBasicSettingDAO(): BasicSettingDAO {
        return new BasicSettingDAO($this->entityManager);
    }

    public function getWithdrawMethodDAO(): WithdrawMethodDAO {
        return new WithdrawMethodDAO($this->entityManager);
    }

    public function getPlanDAO(): PlanDAO {
        return new PlanDAO($this->entityManager);
    }

    public function getTransactionDAO(): TransactionDAO {
        return new TransactionDAO($this->entityManager);
    }

    public function getDepositDAO(): DepositDAO {
        return new DepositDAO($this->entityManager);
    }

    public function getUserBalanceDAO(): UserBalanceDAO {
        return new UserBalanceDAO($this->entityManager);
    }

    public function getSupportDAO(): SupportDAO {
        return new SupportDAO($this->entityManager);
    }

    public function getPaymentMethodDAO(): PaymentMethodDAO {
        return new PaymentMethodDAO($this->entityManager);
    }

    public function getUserDAO(): UserDAO {
        return new UserDAO($this->entityManager);
    }

    public function getPaymentLogDAO(): PaymentLogDAO {
        return new PaymentLogDAO($this->entityManager);
    }

    public function getSupportMessageDAO(): SupportMessageDAO {
        return new SupportMessageDAO($this->entityManager);
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

    public function getUserTreeDAO(): UserTreeDAO {
        return new UserTreeDAO($this->entityManager);
    }

    public function getIncomeDAO(): IncomeDAO {
        return new IncomeDAO($this->entityManager);
    }

    public function getUserPositionDAO(): UserPositionDAO {
        return new UserPositionDAO($this->entityManager);
    }

}
