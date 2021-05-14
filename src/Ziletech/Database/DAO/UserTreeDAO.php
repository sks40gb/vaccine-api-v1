<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserTree;

class UserTreeDAO extends BaseDAO {

    const TYPE_FIRST = 0;
    const TYPE_GROWTH = 1;
    
    public function __construct($entityManager) {
        parent::__construct($entityManager, UserTree::class);
    }

    public function getByUser(User $user, $type = Self::TYPE_FIRST) {
        return $this->get(["user" => $user, "type" => $type]);
    }

    public function findByOwner(User $owner, $type = Self::TYPE_FIRST) {
        return $this->find(["owner" => $owner, "type" => $type]);
    }

    public function getByUserAndLevel(User $user, $level, $type = Self::TYPE_FIRST) {
        return $this->get(["user" => $user, "level" => $level, "type" => $type]);
    }
    
    public function getByUserAndStatus(User $user, $status, $type = Self::TYPE_FIRST) {
        return $this->get(["user" => $user, "status" => $status, "type" => $type]);
    }
    
    public function findByUserAndStatus(User $user, $status, $type = Self::TYPE_FIRST) {
        return $this->find(["user" => $user, "status" => $status, "type" => $type]);
    }

    public function findByUser(User $user, $type = Self::TYPE_FIRST) {
        return $this->find(["user" => $user, "type" => $type]);
    }
    
    public function findGrowthTableByUser(User $user, $type = Self::TYPE_GROWTH) {
        return $this->find(["user" => $user, "type" => $type]);
    }
    
    public function getRootUser($type){
        //@TODO - check if null type can be checked directly.
         $userTreeList =  $this->find(["type" => $type]);
         if($userTreeList != null){
             foreach ($userTreeList as $tree) {
                 if($tree->getParent() == null){
                     return $tree;
                 }
             }
         }
         return null;
    }

}
