<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DAO\Property;
use Ziletech\Database\DAO\StatusType;
use Ziletech\Database\DTO\DepositFundRequestDTO;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\Entity\Deposit;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\User;
use Ziletech\Services\Core\Transaction\TransactionService;
use Ziletech\Services\Plan\Core\Notification\NotificationService;
use Ziletech\Services\Plan\Core\PlanFactory;
use Ziletech\Util\DateUtil;

class DepositService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;
    private $userBalanceService;

    /**
     *
     * @var NotificationService
     */
    private $notification;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->userBalanceService = new UserBalanceService($this->daoFactory);
        $this->userLogService = PlanFactory::getFactory($daoFactory)->getTransactionService();
        $this->notification = PlanFactory::getFactory($daoFactory)->getNotificationService();
    }

    public function convertToDepositDTOList($depositList) {
        $depositDTOList = [];
        foreach ($depositList as $deposit) {
            array_push($depositDTOList, $this->convertToDepositDTO($deposit));
        }
        return $depositDTOList;
    }

    public function getAllDepositList($user = null) {
        return $this->convertToDepositDTOList($this->daoFactory->getDepositDAO()->findDepositByuser($user));
    }

    public function findByStatus($status) {
        return $this->convertToDepositDTOList($this->daoFactory->getDepositDAO()->findByStatus($status));
    }

    public function convertToDepositDTO(Deposit $deposit) {
        $depositDTO = DTOFactory::getDepositDTO($deposit);
        $depositDTO->copyFromDomain($deposit);
        $depositDTO->setUserName($deposit->getUser()->getUserName());
        $depositDTO->setName($deposit->getUser()->getName());
        $depositDTO->setUserEmail($deposit->getUser()->getEmail());
        $depositDTO->setPaymentMethodName($deposit->getPaymentType()->getName());
        $plan = $this->daoFactory->getPlanDAO()->findById($deposit->getRequestedPlanId());
        $depositDTO->setPlan($plan->getName());
        $depositDTO->setPlanPrice($plan->getPrice());
        return $depositDTO;
    }

    public function cancelDeposit($id) {
        $deposit = $this->daoFactory->getDepositDAO()->findById($id);
        $deposit->setStatus(StatusType:: DEPOSIT_CANCEL_STATUS);
        $deposit->setUpdatedAt(DateUtil::getCurrentDate());
        $this->daoFactory->getDepositDAO()->save($deposit);
        return $this->convertToDepositDTO($deposit);
    }

    public function approveDeposit($id) {
        // update deposit
        $deposit = $this->daoFactory->getDepositDAO()->findById($id);
        $deposit->setStatus(StatusType:: DEPOSIT_APPROVE_STATUS);
        $deposit->setUpdatedAt(DateUtil::getCurrentDate());
        $this->daoFactory->getDepositDAO()->save($deposit);

        // active user plan
        $plan = $this->daoFactory->getPlanDAO()->findById($deposit->getRequestedPlanId());
        $user = $deposit->getUser();
        $user->setPlan($plan);
        $this->daoFactory->getUserDAO()->save($user);

        //create user log
        $this->userLogService->createLogForDeposit($deposit);

        //update user balance   
        $userBalance = $this->userBalanceService->createUserBalanceForUser($deposit->getUser());
        $this->userBalanceService->updateBusinessVolume($userBalance, $plan->getBusinessVolume());
        $this->notification->sendInvoice($user->getEmail(), $user->getId());
        return $this->convertToDepositDTO($deposit);
    }

    public function saveDeposit(DepositFundRequestDTO $fundRequestDTO, User $user) {

        $paymentMethod = $this->daoFactory->getPaymentMethodDAO()->findById($fundRequestDTO->getPaymentMethodId());

        //get plan 
        $plan = $this->daoFactory->getPlanDAO()->findById($fundRequestDTO->getPlan());

        //create deposit  for new deposit
        $deposit = EntityFactory::getDeposit();
        $deposit->setRequestedPlanId($plan->getId());
        $deposit->setUser($user);
        $deposit->setAmount($fundRequestDTO->getAmount());
        $deposit->setCharge($fundRequestDTO->getCharge());
        $deposit->setRate($paymentMethod->getRate());
        $deposit->setNetAmount($fundRequestDTO->getNetAmount());
        $deposit->setPaymentType($paymentMethod);
        $deposit->setMessage($fundRequestDTO->getNetAmount() . " deposit request for activate " . $plan->getName());
        $deposit->setTransactionId(uniqid());
        //create deposit proof  for new deposit
        if (isset($fundRequestDTO->image->id)) {
            $image = $this->daoFactory->getFileDAO()->findById($fundRequestDTO->image->id);
            $deposit->setDepositImage($image);
        }
        $this->daoFactory->getDepositDAO()->save($deposit);
    }

    public function filter($filterParams = []) {
        $depositDAO = $this->daoFactory->getDepositDAO();
        $filters = array();
        if (isset($filterParams["userId"])) {
            array_push($filters, Property::getInstance("user", $filterParams["userId"]));
        }
        if (isset($filterParams["transactionId"])) {
            array_push($filters, Property::getInstance("transactionId", $filterParams["transactionId"]));
        }
        if (isset($filterParams["status"])) {
            array_push($filters, Property::getInstance("status", $filterParams["status"]));
        }
        return $this->convertToDepositDTOList($depositDAO->filter($filters));
    }

    public function getDepositListByStatus($status, $user = null) {
        $depositList = null;
        if ($status == null) {
            $depositList = $this->getAllDepositList($user);
        } else {
            $depositList = $this->findByStatus($status);
        }
        return $depositList;
    }

}
