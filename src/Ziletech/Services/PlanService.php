<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\PlanDTO;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Util\DateUtil;

class PlanService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function savePlan(PlanDTO $planDTO) {
        $plan = EntityFactory::getPlan();
        $planDTO->copyToDomain($plan);
        if (isset($planDTO->image->id)) {
            $file = $this->daoFactory->getFileDAO()->findById($planDTO->image->id);
            $plan->setImage($file);
        }
        $this->daoFactory->getPlanDAO()->save($plan);
        return $this->convertToPlanDTO($plan);
    }

    public function convertToPlanDTO($plan) {
        $planDTO = DTOFactory::getPlanDTO();
        $planDTO->copyFromDomain($plan);
        if ($plan->image) {
            $file = $this->daoFactory->getFileDAO()->findById($plan->image->id);
            $planDTO->setImage(DTOFactory:: getFileDTO($file));
        }
        return $planDTO;
    }

    public function updatePlan(PlanDTO $planDTO) {
        $plan = $this->daoFactory->getPlanDAO()->findById($planDTO->id);
        $planDTO->copyToDomain($plan);
        if (isset($planDTO->image->id)) {
            $file = $this->daoFactory->getFileDAO()->findById($planDTO->image->id);
            $plan->setImage($file);
        }
        $plan->setUpdatedAt(DateUtil::getCurrentDate());
        $this->daoFactory->getPlanDAO()->update($plan);
        return $this->convertToPlanDTO($plan);
    }

    public function search() {
        $planList = $this->daoFactory->getPlanDAO()->findAll();
        $planDTOList = array();
        foreach ($planList as $plan) {
            array_push($planDTOList, $this->convertToPlanDTO($plan));
        }
        return $planDTOList;
    }

    public function remove($id) {
        $plan = $this->daoFactory->getPlanDAO()->findById($id);
        $this->daoFactory->getPlanDAO()->remove($plan);
    }

}
