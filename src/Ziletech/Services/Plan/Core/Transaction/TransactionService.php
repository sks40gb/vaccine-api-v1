<?php

namespace Ziletech\Services\Plan\Core\Transaction;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DAO\Property;
use Ziletech\Database\DAO\StatusType;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\Entity\Deposit;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\Transaction;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Database\Entity\Withdraw;
use Ziletech\Services\Plan\Core\Notification\NotificationService;
use Ziletech\Services\Plan\Core\PlanFactory;

class TransactionService {

    /**
     * @var DAOFactory
     */
    protected $daoFactory;

    public const DIRECT_RIFRRAL_BONUS = 15;
    public const SMART_TABLE_BONUS = 16;
    public const GLOBAL_ENTRY = 18;
    public const GLOBAL_TABLE_BONUS = 17;
    public const ADMIN_CHARGE = 20;
    public const TDS_CHARGE = 19;

    /**
     *
     * @var NotificationService
     */
    private $notification;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->notification = PlanFactory::getFactory($daoFactory)->getNotificationService();
    }

    public function createLogForDeposit(Deposit $deposit) {
        $transaction = EntityFactory::getTransaction();
        $transaction->setUser($deposit->getUser());
        $transaction->setTransactionId($deposit->getTransactionId());
        $transaction->setAmount($deposit->getAmount());
        $transaction->setCharge($deposit->getCharge());
        $transaction->setAmountType(StatusType:: DEPOSIT_AMOUNT_TYPE);
        $transaction->setPostBal($this->daoFactory->getUserBalanceDAO()->getUserBalance($deposit->getUser()) + $deposit->getAmount());
        $transaction->setDescription("Deposit " . $deposit->getAmount() . " By " .
                $deposit->getPaymentType()->getName() . " for plan " . $deposit->getUser()->getPlan()->getName() . " activation");
        $this->daoFactory->getTransactionDAO()->save($transaction);
        $this->notification->notifyDeposit(DTOFactory::getUserDTO($deposit->getUser()), $transaction->getDescription());
    }

    public function createLogForWithdraw(Withdraw $withdraw) {
        $transaction = EntityFactory::getTransaction();
        $this->copyToTransaction($withdraw, $transaction);
        $transaction->setAmount($withdraw->getAmount());
        $transaction->setAmountType(StatusType:: WITHHDRAW_REQUEST_AMOUNT_TYPE);
        $transaction->setPostBal($this->daoFactory->getUserBalanceDAO()->getUserBalance($withdraw->getUser()) - $withdraw->getAmount());
        $transaction->setDescription($withdraw->getAmount() . " INR  Withdraw Request Approved Send Via " . $withdraw->getWithdrawMethod()->getName());
        $this->daoFactory->getTransactionDAO()->save($transaction);
        $this->notification->notifyWithdraw(DTOFactory::getUserDTO($withdraw->getUser()), $transaction->getDescription());
    }

    public function createLogForWithdrawCharge(Withdraw $withdraw) {
        $chargeTransaction = EntityFactory::getTransaction();
        $this->copyToTransaction($withdraw, $chargeTransaction);
        $chargeTransaction->setAmount($withdraw->getCharge());
        $chargeTransaction->setAmountType(StatusType:: WITHHDRAW_REQUEST_CHARGE_TYPE);
        $chargeTransaction->setPostBal($this->daoFactory->getUserBalanceDAO()->getUserBalance($withdraw->getUser()) - $withdraw->getNetAmount());
        $adminChargePercent = $this->daoFactory->getGenericCodeDAO()->getByCode("ADMIN_CHARGE")->getDescription();
        $tdsPercent = $this->daoFactory->getGenericCodeDAO()->getByCode("TDS")->getDescription();
        $chargeTransaction->setDescription($withdraw->getCharge() . " debited " . $adminChargePercent . "% Admin and " . $tdsPercent . "% TDS Charged for Withdraw Amount " . $withdraw->getAmount());
        $this->daoFactory->getTransactionDAO()->save($chargeTransaction);
        $this->notification->notifyWithdrawCharge(DTOFactory::getUserDTO($withdraw->getUser()), $chargeTransaction->getDescription());
        return $chargeTransaction;
    }

    public function createLogForActiveUser($user, $userBalance) {
        $owner = $this->daoFactory->getUserDAO()->findById($user->getOwnerId());
        $transaction = EntityFactory::getTransaction();
        $transaction->setUser($owner);
        $transaction->setTransactionId(uniqid());
        $transaction->setAmount($user->getPlan()->getPrice());
        $transaction->setCharge(null);
        $transaction->setAmountType(StatusType::PLAN_ACTIVE);
        $transaction->setPostBal($userBalance->getBalance() - $user->getPlan()->getPrice());
        $transaction->setDescription($user->getPlan()->getPrice() . " INR Charged For " . $user->getUserName() . " Active");
        $this->daoFactory->getTransactionDAO()->save($transaction);
        $this->notification->notifyActiveUser(DTOFactory::getUserDTO($transaction->getUser()), $transaction->getDescription());
    }

    public function createTransactionForDirectBonus(UserTree $userTree) {
        $owner = $userTree->getOwner();
        $transaction = EntityFactory::getTransaction();
        $transaction->setUser($owner);
        if ($userTree->getUser()->getPlan()) {
            $refrralPercent = $this->daoFactory->getGenericCodeDAO()->getByCode("DIRECT_REFERRAL_BONOUS")->getDescription();
            $transaction->setAmount(($userTree->getUser()->getPlan()->getBusinessVolume() * $refrralPercent) / 100);
        } else {
            $transaction->setAmount(0);
        }
        $transaction->setTransactionId(uniqid());
        $transaction->setAmountType(self::DIRECT_RIFRRAL_BONUS);
        $transaction->setDescription($transaction->getAmount() . " INR Credit For Your Referral User " . $userTree->getUser()->getUserName() . " Active");
        $this->daoFactory->getTransactionDAO()->save($transaction);
        $this->notification->notifyDirectReferral(DTOFactory::getUserDTO($transaction->getUser()), $transaction->getDescription());
        return $transaction;
    }

    public function convertToTransactionDTOList($transactionList) {
        $transactionDTOList = array();
        foreach ($transactionList as $trasnaction) {
            array_push($transactionDTOList, $this->convertToTransactionDTO($trasnaction));
        }
        return $transactionDTOList;
    }

    private function convertToTransactionDTO(Transaction $transaction) {
        $transactionDTO = DTOFactory::getTransactionDTO($transaction);
        $transactionDTO->copyFromDomain($transaction);
        $transactionDTO->setUserName($transaction->getUser()->getUserName());
        $transactionDTO->setName($transaction->getUser()->getName());
        return $transactionDTO;
    }

    private function copyToTransaction(Withdraw $withdraw, Transaction $transaction) {
        $transaction->setUser($withdraw->getUser());
        $transaction->setCharge($withdraw->getCharge());
        $transaction->setTransactionId($withdraw->getTransactionId());
        return $transaction;
    }

    public function search($filter) {
        $transactionDAO = $this->daoFactory->getTransactionDAO();
        $filters = array();
        if (isset($filter["userId"])) {
            array_push($filters, Property::getInstance("user", $filter["userId"]));
        }
        if (isset($filter["transactionId"])) {
            array_push($filters, Property::getInstance("transactionId", $filter["transactionId"]));
        }
        return $this->convertToTransactionDTOList($transactionDAO->filter($filters));
    }

    public function currentUserTrasactionList($user) {
        $transactionDAO = $this->daoFactory->getTransactionDAO();
        $filters = array();
        array_push($filters, Property::getInstance("user", $user->getId()));
        return $this->convertToTransactionDTOList($transactionDAO->filter($filters));
    }

}
