<?php

namespace Ziletech\Services\User;

use stdClass;
use Ziletech\Database\DAO\BalanceConstent;
use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DAO\Property;
use Ziletech\Database\DAO\TransactionType;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\SponserResponseDTO;
use Ziletech\Database\DTO\TransactionRequestDTO;
use Ziletech\Database\DTO\UserDTO;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\GenericCodeConstant;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserRole;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\Plan\Core\Notification\EmailNotificationService;
use Ziletech\Services\Plan\Core\PlanFactory;
use Ziletech\Services\Plan\SmartTable\Notification\SmartTableNotificationService;
use Ziletech\Services\UserBalanceService;
use Ziletech\Util\DateUtil;

class UserService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;
    private $transactionService = null;
    private $userBalanceService = null;

    /**
     *
     * @var SmartTableNotificationService
     */
    private $notification;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->transactionService = PlanFactory::getFactory($daoFactory)->getTransactionService();
        $this->userBalanceService = new UserBalanceService($this->daoFactory);
        $this->notification = new SmartTableNotificationService($this->daoFactory);
    }

    public function addUser(UserDTO $userDTO): User {
        //Create new user
        $user = EntityFactory::getUser();
        $userDTO->copyToDomain($user);
        $user->setPassword(password_hash($userDTO->password, PASSWORD_DEFAULT));
        $this->validateUserNameUnique($user);

        //Set the rols
        $role = $this->daoFactory->getRoleDAO()->getByName(UserRole::USER_ROLE);
        $user->setRole($role);

        //Set owner
        $owner = $this->daoFactory->getUserDAO()->getByUserName($userDTO->getOwner()->getUserName());
        $user->setOwner($owner);

        //Set the plan
        if ($userDTO->getPlan()) {
            $user->setPlan($this->daoFactory->getPlanDAO()->findById($userDTO->getPlan()->getId()));
        }
        $user = $this->daoFactory->getUserDAO()->save($user, false);
        return $user;
    }

    function validateUserNameUnique(User $user) {
        $user = $this->daoFactory->getUserDAO()->getByUserName($user->getUserName());
        if ($user != null) {
            throw new ZiletechException("Username {$user->getUserName()} is already taken.");
        }
    }

    public function requestPasswordReset(string $email) {
        $token = $this->generateToken();
        $user = $this->daoFactory->getUserDAO()->getByEmail($email);
        $user->setResetPasswordToken($token);
        $this->daoFactory->getUserDAO()->update($user);
        $this->notification->sendResetPasswordEmail($email, $token, DTOFactory::getUserDTO($user));
    }

    public function generateToken() {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    public function convertToUserDTO($user) {
        $userDTO = DTOFactory::getUserDTO();
        $userDTO->copyFromDomain($user);
        $userDTO->setRole(DTOFactory:: getRoleDTO($user->getRole()));
        $userBalance = $this->daoFactory->getUserBalanceDAO()->getBalanceByUser($user);
        if ($userBalance != null) {
            $userDTO->setBalance($this->userBalanceService->convertToBalanceDTO($userBalance));
        }
        if ($user->profilePic) {
            $file = $this->daoFactory->getFileDAO()->findById($user->profilePic->id);
            $userDTO->setProfilePic(DTOFactory:: getFileDTO($file));
        }
        return $userDTO;
    }

    public function getByLoginName($loginName) {
        $user = $this->daoFactory->getUserDAO()->getByUserName($loginName);
        return $this->convertToUserDTO($user);
    }

    public function setUserStatus($id, $status) {
        $user = $this->daoFactory->getUserDAO()->findById($id);
        $user->setStatus($status);
        $this->daoFactory->getUserDAO()->save($user);
        return $this->convertToUserDTO($user);
    }

    public function remove($id) {
        $user = $this->daoFactory->getUserDAO()->findById($id);
        $this->daoFactory->getUserDAO()->remove($user);
    }

    public function convertToUserDTOList($userList) {
        $userDTOList = [];
        foreach ($userList as $user) {
            array_push($userDTOList, $this->convertToUserDTO($user));
        }
        return $userDTOList;
    }

    public function getUserListByOwnerId($user) {
        $filters = [];
        array_push($filters, Property::getInstance("ownerId", $user->getId()));
        $userList = $this->daoFactory->getUserDAO()->filter($filters);
        return $this->convertToUserDTOList($userList);
    }

    public function update(UserDTO $userDTO) {
        $user = $this->daoFactory->getUserDAO()->findById($userDTO->id);
        $userDTO->copyToDomain($user);
        //set role as user 
        if ($user->getRole()) {
            $role = $this->daoFactory->getRoleDAO()->findById($user->getRole()->getId());
            $user->setRole($role);
        }
        if (isset($userDTO->profilePic->id)) {
            $file = $this->daoFactory->getFileDAO()->findById($userDTO->profilePic->id);
            $user->setProfilePic($file);
        } else {
            $user->setProfilePic(null);
        }
        $user->setUpdatedAt(DateUtil::getCurrentDate());
        $this->daoFactory->getUserDAO()->update($user);
        return $this->convertToUserDTO($user);
    }

    public function changeStatusToConfirm($id) {
        $status = true;
        $user = $this->daoFactory->getUserDAO()->findById($id);
        $userBalance = $this->daoFactory->getUserBalanceDAO()->getBalanceByUser($user->getOwnerId());
        if ($userBalance->getBalance() > $user->getPlan()->getPrice()) {
            //create transaction 
            $this->transactionService->createLogForActiveUser($user, $userBalance);
            //update user balance
            $this->userBalanceService->updateUserBalance($userBalance, $user->getPlan()->getPrice());

            //update status
            $user->setpStatus(true);
            $this->daoFactory->getUserDAO()->save($user);
            $status = false;
        }
        return $status;
    }

    public function search($filter) {
        $userDAO = $this->daoFactory->getUserDAO();
        $filters = array();
        if (isset($filter["userName"])) {
            array_push($filters, Property::getInstance("userName", $filter["userName"]));
        }
        if (isset($filter["id"])) {
            array_push($filters, Property::getInstance("id", $filter["id"]));
        }
        if (isset($filter["status"])) {
            array_push($filters, Property::getInstance("status", $filter["status"]));
        }
        $userList = $userDAO->filter($filters);
        return $this->convertToUserDTOList($userList);
    }

    public function getNewUserList($id) {
        $planDashboardList = [];
        $criteria = [];
        array_push($criteria, Property::getInstance("ownerId", $id));
        foreach ($this->daoFactory->getUserDAO()->filter($criteria) as $user) {
            $planDashboardDTO = DTOFactory::getPlanDashboardDTO();
            if ($user->getPStatus() == false) {
                $plan = $user->getPlan();
                $planDashboardDTO->setPlanName($plan->getName());
                $planDashboardDTO->setPrice($plan->getPrice());
                $planDashboardDTO->setUserName($user->getUserName());
                $planDashboardDTO->setUserId($user->getId());
                array_push($planDashboardList, $planDashboardDTO);
            }
        }
        return $planDashboardList;
    }

    public function updateUserBalance(TransactionRequestDTO $requestDTO) {
        $user = $this->daoFactory->getUserDAO()->findById($requestDTO->getId());
        $userBalanceDTO = DTOFactory::getUserBalanceDTO();
        $userBalance = $this->daoFactory->getUserBalanceDAO()->getBalanceByUser($requestDTO->getId());
        $transactionDTO = DTOFactory::getTransactionDTO();
        if ($userBalance != null) {
            $userBalanceDTO->copyFromDomain($userBalance);
        } else {
            $userBalance = EntityFactory::getUserBalance();
            $userBalanceDTO->copyFromDomain($userBalance);
            $userBalance->setUpdatedAt(DateUtil::getCurrentDate());
            $userBalance->setUser($user);
        }
        if ($requestDTO->getOperation() == BalanceConstent::OPERATION_ADD) {
            $userBalanceDTO->setBalance($userBalance->getBalance() + $requestDTO->getAmount());
            $transactionDTO->setAmountType(TransactionType::ADD_BALANCE_TYPE);
            $transactionDTO->setPostBal($userBalance->getBalance() + $requestDTO->getAmount());
            $transactionDTO->setDescription($requestDTO->getAmount() . " INR - " . $requestDTO->getReason());
        } else {
            $userBalanceDTO->setBalance($userBalance->getBalance() - $requestDTO->getAmount());
            $transactionDTO->setAmountType(TransactionType::SUBTRACT_BALANCE_TYPE);
            $transactionDTO->setPostBal($userBalanceDTO->getBalance() - $requestDTO->getAmount());
            $transactionDTO->setDescription("Subtract " . $requestDTO->getAmount() . " INR - " . $requestDTO->getReason());
        }
        $userBalanceDTO->copyToDomain($userBalance);
        $transactionDTO->setAmount($requestDTO->getAmount());
        $transactionDTO->setTransactionId(uniqid());
        $transaction = EntityFactory::getTransaction();
        $transactionDTO->copyToDomain($transaction);
        $transaction->setUser($user);
        $this->daoFactory->getTransactionDAO()->save($transaction);
        return $this->daoFactory->getUserBalanceDAO()->save($userBalance);
    }

    public function getUserByReferralId($refId) {
        $user = $this->daoFactory->getUserDAO()->getByReferralId($refId);
        $sponserDTO = new SponserResponseDTO();
        $sponserDTO->setName($user->getName());
        $sponserDTO->setUserId($user->getUserName());
        return $sponserDTO;
    }

    public function getSponserByUserName($userName) {
        $user = $this->daoFactory->getUserDAO()->getByUserName($userName);
        return $this->copyToSponserDTO($user);
    }

    private function copyToSponserDTO($user) {
        $sponserDTO = new SponserResponseDTO();
        $sponserDTO->setName($user->getName());
        $sponserDTO->setUserId($user->getUserName());
        return $sponserDTO;
    }

    public function generateUserReferralLink(User $user) {
        $hostName = $this->daoFactory->getGenericCodeDAO()->getByCode("HOST_NAME")->getDescription();
        return $hostName . "/register?refid=" . $user->getReferralId();
    }

    function calculateTeamBusinessVolume(UserTree $userTree) {
        $teamBusinessVolume = 0;
        foreach ($userTree->getChildren() as $tree) {
            if ($tree->getUser()->getBalance()) {
                $teamBusinessVolume += $tree->getUser()->getBalance()->getBusinessVolume();
            }
            $childBv = $this->calculateTeamBusinessVolume($tree);
            $teamBusinessVolume += $childBv;
        }
        return $teamBusinessVolume;
    }

}
