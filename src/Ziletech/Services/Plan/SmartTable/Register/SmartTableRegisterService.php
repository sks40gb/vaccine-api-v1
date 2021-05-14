<?php

namespace Ziletech\Services\Plan\SmartTable\Register;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\UserTreeDTO;
use Ziletech\Services\Plan\Core\Notification\NotificationService;
use Ziletech\Services\Plan\Core\PlanFactory;
use Ziletech\Services\Plan\Core\Register\RegisterService;
use Ziletech\Services\Plan\SmartTable\SmartTablePlanService;
use Ziletech\Util\DateUtil;

class SmartTableRegisterService extends RegisterService {

    const USER_STATUS_ACTIVE = 1;

    /**
     *
     * @var SmartTablePlanService
     */
    private $smartTablePlanService;

    /**
     *
     * @var NotificationService
     */
    private $notification;

    public function __construct(DAOFactory $daoFactory) {
        parent::__construct($daoFactory);
        $this->smartTablePlanService = new SmartTablePlanService($daoFactory);
        $this->notification = PlanFactory::getFactory($daoFactory)->getNotificationService();
    }

    public function addUser(UserTreeDTO $userTreeDTO) {
        return parent::addUser($userTreeDTO);
    }

    public function activateUser(string $username) {
        //Activate the user
        $user = $this->daoFactory->getUserDAO()->getByUserName($username);
        $user->setStatus(self::USER_STATUS_ACTIVE);
        $user->setActivationDate(DateUtil::getCurrentDate());
        $this->daoFactory->getUserDAO()->update($user, false);
        $this->notification->notifyUserActive(DTOFactory::getUserDTO($user));
        $newUserTree = $this->smartTablePlanService->execute($user, $user->getOwner(), $user->getOwner());
        return $newUserTree;
    }

}
