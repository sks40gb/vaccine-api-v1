<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\Setting;

class BasicSettingDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, Setting::class);
    }
    
    public function getByCategory(){
        return $this->findAll();
    }
    
    public function getCompanyDetails(){
        return $this->get(["description"=>"company_details"]);
    }
}
