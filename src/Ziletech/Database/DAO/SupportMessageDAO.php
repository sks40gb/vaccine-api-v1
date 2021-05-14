<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\SupportMessage;

class SupportMessageDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, SupportMessage::class);
        }

    public function getSupportMessegeByTicket($ticketNumber) {
        $criteria = [];
        array_push($criteria, Property::getInstance("ticketNumber", $ticketNumber));
        return $this->filter($criteria,["orderBy" => "createdAt", "order" => "DESC"]);
    }

}
