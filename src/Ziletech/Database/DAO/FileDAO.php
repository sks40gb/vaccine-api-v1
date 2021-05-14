<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\File;

class FileDAO extends BaseDAO{

    public function __construct($entityManager) {
         parent::__construct($entityManager, File::class);
    }
    
}
