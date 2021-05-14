<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\UserBalance;

class UserBalanceService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function updateUserBalance(UserBalance $userBalance, $amount) {
        $userBalance->setBalance($userBalance->getBalance() + $amount);
        $this->daoFactory->getUserBalanceDAO()->save($userBalance);
    }

    public function subtractBalance(UserBalance $userBalance, $amount) {
        $userBalance->setBalance($userBalance->getBalance() - $amount);
        $this->daoFactory->getUserBalanceDAO()->save($userBalance);
    }

    public function updateBusinessVolume(UserBalance $userBalance, $businessVolume) {
        $userBalance->setBusinessVolume($userBalance->getBusinessVolume() + $businessVolume);
        $this->daoFactory->getUserBalanceDAO()->save($userBalance);
    }

    public function createUserBalanceForUser($user) {
        $userBalance = $this->daoFactory->getUserBalanceDAO()->getBalanceByUser($user);
        if ($userBalance == null) {
            $userBalance = EntityFactory::getUserBalance();
            $userBalance->setUser($user);
            $userBalance->setBalance(0);
            $userBalance->setBusinessVolume(0);
        }
        return $userBalance;
    }

    public function convertToBalanceDTO(UserBalance $userBalance) {
        $userBalanceDTO = DTOFactory::getUserBalanceDTO($userBalance);
        return $userBalanceDTO;
    }

}
