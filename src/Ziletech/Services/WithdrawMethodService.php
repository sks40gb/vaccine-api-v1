<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Util\DateUtil;

class WithdrawMethodService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function convertToWithdraMethodDTOList($withdrawList) {
        $withdrawMethodList = [];
        foreach ($withdrawList as $withdrawMethod) {
            array_push($withdrawMethodList, $this->convertTOWithdrawMethodDTO($withdrawMethod));
        }
        return $withdrawMethodList;
    }

    public function convertTOWithdrawMethodDTO($withdrawMethod) {
        $withdrawMethodDTO = DTOFactory::getWithdrawMethodDTO();
        $withdrawMethodDTO->copyFromDomain($withdrawMethod);
        if ($withdrawMethod->image) {
            $file = $this->daoFactory->getFileDAO()->findById($withdrawMethod->image->id);
            $withdrawMethodDTO->setImage(DTOFactory:: getFileDTO($file));
        }
        return $withdrawMethodDTO;
    }

    public function saveMethod($withdrawMethodDTO) {
        $withdrawMethod = EntityFactory::getWithdrawMethod();
        $this->copyToWithdrawMethod($withdrawMethod, $withdrawMethodDTO);
        $this->daoFactory->getWithdrawMethodDAO()->save($withdrawMethod);
        return $this->convertTOWithdrawMethodDTO($withdrawMethod);
    }

    public function updateMethod($withdrawMethodDTO) {
        $withdrawMethod = $this->daoFactory->getWithdrawMethodDAO()->findById($withdrawMethodDTO->id);
        $this->copyToWithdrawMethod($withdrawMethod, $withdrawMethodDTO);
        $withdrawMethod->setUpdatedAt(DateUtil::getCurrentDate());
        $this->daoFactory->getWithdrawMethodDAO()->update($withdrawMethod);
        return $this->convertTOWithdrawMethodDTO($withdrawMethod);
    }

    private function copyToWithdrawMethod($withdrawMethod, $withdrawMethodDTO) {
        $withdrawMethodDTO->copyToDomain($withdrawMethod);
        if (isset($withdrawMethodDTO->image->id)) {
            $file = $this->daoFactory->getFileDAO()->findById($withdrawMethodDTO->image->id);
            $withdrawMethod->setImage($file);
        }
    }

}
