<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DAO\StatusType;
use Ziletech\Database\DTO\CalulateWithdrawFundRequestDTO;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\Withdraw;
use Ziletech\Models\ChargeModel;
use Ziletech\Services\Plan\Core\PlanFactory;
use Ziletech\Services\Plan\Core\Transaction\TransactionService;
use Ziletech\Util\DateUtil;

class WithdrawService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;
    private $userBalanceService;
    /**
     *
     * @var TransactionService
     */
    private $transactionService;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->userBalanceService = new UserBalanceService($this->daoFactory);
        $this->transactionService = PlanFactory::getFactory($daoFactory)->getTransactionService();
    }

    public function getAllWithdrawList(User $user = null) {
        $withdrawList = [];
        foreach ($this->daoFactory->getWithdrawLogDAO()->findByUser($user) as $withdrawLog) {
            array_push($withdrawList, $this->convertToWithdrawDTO($withdrawLog));
        }
        return $withdrawList;
    }

    public function findByStatus($status) {
        $withdrawList = [];
        foreach ($this->daoFactory->getWithdrawLogDAO()->findByStatus($status) as $withdrawLog) {
            array_push($withdrawList, $this->convertToWithdrawDTO($withdrawLog));
        }
        return $withdrawList;
    }

    public function convertToWithdrawDTO(Withdraw $withdrawLog) {
        $withdrawLogDTO = DTOFactory::getWithdrawLogDTO($withdrawLog);
        $withdrawLogDTO->copyFromDomain($withdrawLog);
        $withdrawLogDTO->setUserName($withdrawLog->getUser()->getUserName());
        $withdrawLogDTO->setBankName($withdrawLog->getUser()->getBankName());
        $withdrawLogDTO->setBranchName($withdrawLog->getUser()->getBranchName());
        $withdrawLogDTO->setAccountNumber($withdrawLog->getUser()->getAccountNo());
        $withdrawLogDTO->setIfsc($withdrawLog->getUser()->getIfscCode());
        $withdrawLogDTO->setPanNumber($withdrawLog->getUser()->getPanNumber());
        $withdrawLogDTO->setName($withdrawLog->getUser()->getName());
        $withdrawLogDTO->setWithdrawMethod($withdrawLog->getWithdrawMethod()->getName());
        return $withdrawLogDTO;
    }

    public function approveWithdraw($id) {

        //save withdwal
        $withdrawLog = $this->daoFactory->getWithdrawLogDAO()->findById($id);
        $withdrawLog->setStatus(StatusType:: SUCCESS_WITHDRAW_STATUS);
        $withdrawLog->setUpdatedAt(DateUtil::getCurrentDate());
        $this->daoFactory->getWithdrawLogDAO()->save($withdrawLog);

        // get user balance
        $userBalance = $this->daoFactory->getUserBalanceDAO()->getBalanceByUser($withdrawLog->getUser());

        //create user log for withdraw and charge
        $this->transactionService->createLogForWithdraw($withdrawLog);
        $this->transactionService->createLogForWithdrawCharge($withdrawLog);

        //Update user balance
        $this->userBalanceService->subtractBalance($userBalance, $withdrawLog->getNetAmount());
        return $withdrawLog;
    }

    public function copyToWithdrawLog(CalulateWithdrawFundRequestDTO $fundRequestDTO, User $user) {
        $withdrawMethod = $this->daoFactory->getWithdrawMethodDAO()->findById($fundRequestDTO->getWithdrawMethodId());
        //create withdraw log request
        $withdrawLog = EntityFactory::getWithdrawLog();
        $withdrawLog->setTransactionId(uniqid());
        $withdrawLog->setUser($user);
        $withdrawLog->setCharge($fundRequestDTO->getCharge());
        $withdrawLog->setAmount($fundRequestDTO->getAmount());
        $withdrawLog->setNetAmount($fundRequestDTO->getTotalAmount());
        $withdrawLog->setWithdrawMethod($withdrawMethod);
        $withdrawLog->setSendDetails($fundRequestDTO->getDetails());
        $withdrawLog->setMessage($fundRequestDTO->getMessage());
        $withdrawLog->setStatus(StatusType:: PENDING_WITHDRAW_STATUS);
        return $withdrawLog;
    }

    public function cancelWithdraw($withdrawLogId) {
        $withdraw = $this->daoFactory->getWithdrawLogDAO()->findById($withdrawLogId);
        $withdraw->setStatus(StatusType:: REFUNDED_WITHDRAW_STATUS);
        $withdraw->setUpdatedAt(DateUtil::getCurrentDate());
        $this->daoFactory->getWithdrawLogDAO()->save($withdraw);
        return $this->convertToWithdrawDTO($withdraw);
    }

    public function getCharges() {
        $charges = new ChargeModel();
        $charges->adminCharge = $this->daoFactory->getGenericCodeDAO()->getByCode("ADMIN_CHARGE")->getDescription();
        $charges->tdsCharge = $this->daoFactory->getGenericCodeDAO()->getByCode("TDS")->getDescription();
        return $charges;
    }

}
