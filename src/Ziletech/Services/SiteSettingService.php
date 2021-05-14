<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\BasicSettingDTO;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\Entity\EntityFactory;

class SiteSettingService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function convertToBasicSettingDTO($basicSetting) {
        $basicSettingDTO = DTOFactory::getBasicSettingDTO();
        $basicSettingDTO->copyFromDomain($basicSetting);
        if ($basicSetting->image) {
            $file = $this->daoFactory->getFileDAO()->findById($basicSetting->image->id);
            $basicSettingDTO->setImage(DTOFactory:: getFileDTO($file));
        }
        return $basicSettingDTO;
    }

    public function saveBasicSetting(BasicSettingDTO $basicSettingDTO) {
        $basicSetting = EntityFactory::getSetting();
        $basicSettingDTO->copyToDomain($basicSetting);
        if (isset($basicSettingDTO->image->id)) {
            $file = $this->daoFactory->getFileDAO()->findById($basicSettingDTO->image->id);
            $basicSetting->setImage($file);
        }
        $this->daoFactory->getBasicSettingDAO()->save($basicSetting);
        return $this->convertToBasicSettingDTO($basicSetting);
    }

    public function updateBasicSetting(BasicSettingDTO $basicSettingDTO) {
        $basicSetting = $this->daoFactory->getBasicSettingDAO()->findById($basicSettingDTO->id);
        $basicSettingDTO->copyToDomain($basicSetting);
        if (isset($basicSettingDTO->image->id)) {
            $file = $this->daoFactory->getFileDAO()->findById($basicSettingDTO->image->id);
            $basicSetting->setImage($file);
        }
        $this->daoFactory->getBasicSettingDAO()->update($basicSetting);
        return $this->convertToBasicSettingDTO($basicSetting);
    }

    public function search() {
        $basicSettingList = $this->daoFactory->getBasicSettingDAO()->getByCategory();
        $basicSettingListDTOList = array();
        foreach ($basicSettingList as $basicSetting) {
            //@TODO hard coded value
            if ($basicSetting->getDescription() != "company_details") {
                array_push($basicSettingListDTOList, $this->convertToBasicSettingDTO($basicSetting));
            }
        }
        return $basicSettingListDTOList;
    }

    public function getGeneralSetting() {
        $basicSetting = $this->daoFactory->getBasicSettingDAO()->getCompanyDetails();
        return $this->convertToBasicSettingDTO($basicSetting);
    }

    public function remove($id) {
        $basicSetting = $this->daoFactory->getBasicSettingDAO()->findById($id);
        $this->daoFactory->getBasicSettingDAO()->remove($basicSetting);
    }

}
