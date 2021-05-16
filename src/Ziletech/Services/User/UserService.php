<?php

namespace Ziletech\Services\User;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DAO\Property;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\UserDTO;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserRole;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Util\DateUtil;

class UserService {

    /**
     *
     * @var UserEmailNotificationService
     */
    private $notification;

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->notification = new UserEmailNotificationService($this->daoFactory);
    }

    public function addUser(UserDTO $userDTO): User {
        //Create new user
        $user = EntityFactory::getUser();
        $userDTO->copyToDomain($user);
        $user->setPassword(password_hash($userDTO->password, PASSWORD_DEFAULT));
        $this->validateUserNameUnique($user);

        //Set the role
        $role = $this->daoFactory->getRoleDAO()->getByName(UserRole::USER_ROLE);
        $user->setRole($role);

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

    public function update(UserDTO $userDTO): UserDTO {
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


}
