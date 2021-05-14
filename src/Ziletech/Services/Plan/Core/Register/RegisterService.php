<?php

namespace Ziletech\Services\Plan\Core\Register;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\UserTreeDTO;
use Ziletech\Services\Plan\Core\Notification\NotificationService;
use Ziletech\Services\Plan\Core\PlanFactory;
use Ziletech\Services\User\UserService;

abstract class RegisterService {

    /**
     * @var DAOFactory
     */
    protected $daoFactory;

    /**
     *
     * @var UserService
     */
    protected $userService;
    
    
    /**
     *
     * @var NotificationService
     */
    private $notification;

    public function __construct(DAOFactory $daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->userService = new UserService($daoFactory);
        $this->notification = PlanFactory::getFactory($daoFactory)->getNotificationService();
    }

    public function addUser(UserTreeDTO $userTreeDTO) {
        //Add user
        $userDTO = $userTreeDTO->getUser();
        $password = $userDTO->getPassword();
        $user = $this->userService->addUser($userDTO);
        $this->daoFactory->getUserDAO()->flush();
        
        //send id and password
        $this->notification->notifyRegister($password, $userDTO);
        return $user;
    }

    abstract public function activateUser(string $username);
}
