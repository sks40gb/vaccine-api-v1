<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DAO\StatusType;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\OpenSupportMessageRequestDTO;
use Ziletech\Database\DTO\SupportMessageDTO;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\SupportMessage;
use Ziletech\Database\Entity\User;
use Ziletech\Util\DateUtil;

class SupportMessageService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function convertToMessageDTO(SupportMessage $supportMessage) {
        $messageDTO = DTOFactory:: getSupportMessageDTO();
        $messageDTO->copyFromDomain($supportMessage);
        $messageDTO->setSupport(DTOFactory:: getSupportDTO($supportMessage->getSupport()));
        $messageDTO->setUser(DTOFactory:: getUserDTO($supportMessage->getUser()));
        if ($supportMessage->getUser()->profilePic) {
            $file = $this->daoFactory->getFileDAO()->findById($supportMessage->getUser()->getProfilePic()->getId());
            $messageDTO->getUser()->setProfilePic(DTOFactory:: getFileDTO($file));
        }
        $messageDTO->setUserName($supportMessage->getUser()->getName());
        return $messageDTO;
    }

    public function convertToSupportMessageDTOList($supportMessageList) {
        $supportMessageDTOList = [];
        foreach ($supportMessageList as $supportMessage) {
            array_push($supportMessageDTOList, $this->convertToMessageDTO($supportMessage));
        }
        return $supportMessageDTOList;
    }

    public function answerToUserMessege(SupportMessageDTO $supportMessageDTO, User $user) {
        $support = $this->daoFactory->getSupportDAO()->findById($supportMessageDTO->getSupport()->getId());
        $supportMessage = $this->copyToSupportMessage($supportMessageDTO, $support);
        $supportMessage->setUser($user);
        $supportMessage->setType(StatusType::ADMIN_TYPE);
        $support->setStatus(StatusType::ANSWERED_STATUS);
        $supportMessage->setSupport($support);
        $this->daoFactory->getSupportMessageDAO()->save($supportMessage);
        return $this->convertToMessageDTO($supportMessage);
    }

    public function saveMessegeFromUser(SupportMessageDTO $supportMessageDTO, User $user) {
        $support = $this->daoFactory->getSupportDAO()->findById($supportMessageDTO->getSupport()->getId());
        $support->setStatus(StatusType::CUSTOMER_REPLY_STATUS);
        $supportMessage = $this->copyToSupportMessage($supportMessageDTO, $support);
        $supportMessage->setUser($user);
        $supportMessage->setType(StatusType::USER_TYPE);
        $supportMessage->setSupport($support);
        $this->daoFactory->getSupportMessageDAO()->save($supportMessage);
        return $this->convertToMessageDTO($supportMessage);
    }

    private function copyToSupportMessage(SupportMessageDTO $supportMessageDTO, $support) {
        $supportMessage = EntityFactory::getSupportMessage();
        $supportMessageDTO->copyToDomain($supportMessage);
        $supportMessage->setTicketNumber($support->getTicketNumber());
        $supportMessage->setUpdatedAt(DateUtil::getCurrentDate());
        $support->setUpdatedAt(DateUtil::getCurrentDate());
        return $supportMessage;
    }

    public function createNewTicket(OpenSupportMessageRequestDTO $messageRequestDTO, User $user) {
        $support = EntityFactory::getSupport();
        //save Support
        $support->setSubject($messageRequestDTO->getSubject());
        $support->setTicketNumber(uniqid());
        $support->setStatus(StatusType::TICKET_OPENED_STATUS);
        $support->setUser($user);
        $support = $this->daoFactory->getSupportDAO()->save($support);

        //Save support message
        $message = EntityFactory::getSupportMessage();
        $message->setMessage($messageRequestDTO->getMessage());
        $message->setType(StatusType::USER_TYPE);
        $message->setTicketNumber($support->getTicketNumber());
        $message->setUser($user);
        $message->setSupport($support);
        return $this->daoFactory->getSupportMessageDAO()->save($message);
    }

}
