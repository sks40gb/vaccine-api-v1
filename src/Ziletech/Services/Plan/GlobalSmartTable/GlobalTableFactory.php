<?php

namespace Ziletech\Services\Plan\Core;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\Plan\Core\Register\RegisterService;

class SmartTableFactory implements PlanFactory {

    /**
     *
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct(DAOFactory $daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function getRegisterService(): RegisterService {
        throw new ZiletechException("Yet to be implemented");
    }

}
