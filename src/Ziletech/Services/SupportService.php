<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DAO\StatusType;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\Entity\Support;
use Ziletech\Util\DateUtil;

class SupportService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;
    private $supportMessageService;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->supportMessageService = new SupportMessageService($daoFactory);
    }

    public function convertTOSupportDTO(Support $support) {
        $supportDTO = DTOFactory::getSupportDTO();
        $supportDTO->copyFromDomain($support);
        foreach ($support->getSupportMessagesList() as $supportMessage) {
            array_push($supportDTO->supportMessagesList, $this->supportMessageService->convertToMessageDTO($supportMessage));
        }
        return $supportDTO;
    }

    public function convertTOSupportDTOList($supportList) {
        $supportDTOList = [];
        foreach ($supportList as $support) {
            array_push($supportDTOList, $this->convertTOSupportDTO($support));
        }
        return $supportDTOList;
    }

    public function closeSupport($id) {
        $support = $this->daoFactory->getSupportDAO()->findById($id);
        $support->setStatus(StatusType:: SUPPORT_CLOSE_STATUS);
        $support->setUpdatedAt(DateUtil::getCurrentDate());
        $this->daoFactory->getSupportDAO()->save($support);
        return $this->convertTOSupportDTO($support);
    }

}
