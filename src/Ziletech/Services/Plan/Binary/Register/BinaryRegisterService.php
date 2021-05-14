<?php

namespace Ziletech\Services\Plan\Binary\Register;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\UserTreeDTO;
use Ziletech\Services\Plan\Binary\BinaryPlanService;
use Ziletech\Services\Plan\Core\Register\RegisterService;
use Ziletech\Util\DateUtil;

class BinaryRegisterService extends RegisterService {

    const USER_STATUS_ACTIVE = 1;

    private $binaryPlanService;

    public function __construct(DAOFactory $daoFactory) {
        parent::__construct($daoFactory);
        $this->binaryPlanService = new BinaryPlanService($daoFactory);
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
        $newUserTree = $this->binaryPlanService->execute($user, $user->getOwner(), $user->getOwner());
        return $newUserTree;
    }
}
