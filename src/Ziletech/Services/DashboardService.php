<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DAO\StatusType;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\Entity\User;
use Ziletech\Services\Plan\Core\TreeConstant;
use Ziletech\Services\User\UserService;

class DashboardService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function getUserStatistics() {
        $statisticsDTO = DTOFactory::getUserStatisticsDTO();
        $statisticsDTO->setTotalUser($this->daoFactory->getUserDAO()->getTotalUser());
        $statisticsDTO->setTotalBlockUser($this->daoFactory->getUserDAO()->getTotalBlockUser());
        $statisticsDTO->setTotalActiveUser($this->daoFactory->getUserDAO()->getTotalActiveUser());
        return $statisticsDTO;
    }

    public function getDepositStatistics() {
        $depositStatisticsDTO = DTOFactory::getDepositStatisticsDTO();
        $depositStatisticsDTO->setNumberOfDeposits(sizeof($this->daoFactory->getDepositDAO()->findAll()));
        $depositStatisticsDTO->setDepositMethod($this->daoFactory->getPaymentMethodDAO()->getDepositMethod());
        $depositStatisticsDTO->setTotalDeposit($this->daoFactory->getDepositDAO()->getTotalDeposit());
        $depositStatisticsDTO->setTotalDepositPending($this->daoFactory->getDepositDAO()->getTotalDepositPending());
        return $depositStatisticsDTO;
    }

    public function getDepositPlanStatistics() {
        $depositPlanStatisticsDTO = DTOFactory::getDepositPlanStatisticsDTO();
        $depositPlanStatisticsDTO->setTotalActivePlan($this->daoFactory->getPlanDAO()->getTotalActivePlan());
        $depositPlanStatisticsDTO->setTotalDeactivePlan($this->daoFactory->getPlanDAO()->getTotalDeactivePlan());
        $depositPlanStatisticsDTO->setTotalPlan($this->daoFactory->getPlanDAO()->getTotalPlan());
        return$depositPlanStatisticsDTO;
    }

    public function getWithdrawStatistics() {
        $withdrawStatisticsDTO = DTOFactory::getWithdrawStatisticsDTO();
        $withdrawStatisticsDTO->setNumberOfWithdraw($this->daoFactory->getWithdrawLogDAO()->getNumberOfWithdraw());
        $withdrawStatisticsDTO->setPendingWithdraw(sizeof($this->daoFactory->getWithdrawLogDAO()->findByStatus(StatusType::PENDING_WITHDRAW_STATUS)));
        $withdrawStatisticsDTO->setRefundedWithdraw(sizeof($this->daoFactory->getWithdrawLogDAO()->findByStatus(StatusType::REFUNDED_WITHDRAW_STATUS)));
        $withdrawStatisticsDTO->setSuccessWithdraw(sizeof($this->daoFactory->getWithdrawLogDAO()->findByStatus(StatusType::SUCCESS_WITHDRAW_STATUS)));
        $withdrawStatisticsDTO->setWithdrawMethod($this->daoFactory->getWithdrawMethodDAO()->getWithdrawMethod());
        $withdrawStatisticsDTO->setWithdrawAmount($this->daoFactory->getWithdrawLogDAO()->getWithdrawAmount());
        $withdrawStatisticsDTO->setWithdrawCharge($this->daoFactory->getWithdrawLogDAO()->getWithdrawCharge());
        return$withdrawStatisticsDTO;
    }

    public function getDashboardToolbar() {
        $dashboardToolbarDTO = DTOFactory::getDashboardToolbarDTO();
        $dashboardToolbarDTO->setAdminProfit($this->daoFactory->getTransactionDAO()->getAdminProfit());
        $dashboardToolbarDTO->setPendingSupportTicket($this->daoFactory->getSupportDAO()->pendingSupportCount());
        $dashboardToolbarDTO->setTotalDeposit($this->daoFactory->getDepositDAO()->getTotalDeposit());
        $dashboardToolbarDTO->setTotalWithdraw($this->daoFactory->getWithdrawLogDAO()->getWithdrawAmount());
        return$dashboardToolbarDTO;
    }

    public function getUserDashboardToolbar(User $user) {
        $userDashboardToolbarDTO = DTOFactory::getUserDashboardToolbarDTO();
        //balance information
        if ($user->getBalance() != null) {
            $userDashboardToolbarDTO->setCurrentBalance($user->getBalance()->getBalance());
            $userDashboardToolbarDTO->setBusinessVolume($user->getBalance()->getBusinessVolume());

            $userTree = $this->daoFactory->getUserTreeDAO()->getByUserAndLevel($user, TreeConstant::LEVEL_FIRST);
            if ($userTree != null) {
                $userService = new UserService($this->daoFactory);
                $userDashboardToolbarDTO->setTeamBusinessVolume($userService->calculateTeamBusinessVolume($userTree));
            } else {
                $userDashboardToolbarDTO->setTeamBusinessVolume(0);
            }
        }
        //sponser information
        $userDashboardToolbarDTO->setSponserId($user->getOwner()->getUserName());
        $userDashboardToolbarDTO->setSponserName($user->getOwner()->getName());

        $userDashboardToolbarDTO->setActivationDate($user->getActivationDate());
        $userDashboardToolbarDTO->setJoinDate($user->getCreatedAt());
        //plan name
        if ($user->getPlan() != null) {
            $userDashboardToolbarDTO->setPlanName($user->getPlan()->getName());
        }

        $userDashboardToolbarDTO->setDeposit($this->daoFactory->getDepositDAO()->getUserTotalDeposit($user->getId()));
        $userDashboardToolbarDTO->setWithdraws($this->daoFactory->getWithdrawLogDAO()->getNumberOfWithdraw($user->getId()));
        return$userDashboardToolbarDTO;
    }

}
