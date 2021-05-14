<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\PlanDTO;
use Ziletech\Database\DTO\UserBalanceDTO;
use Ziletech\Database\DTO\UserDTO;
use Ziletech\Database\DTO\UserPositionDTO;
use Ziletech\Database\DTO\UserTreeDTO;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\TreeConstant;
use Ziletech\Services\User\UserService;

class GenelogyService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    function getTree(UserTree $userTree, $depth = 2) {
        if ($depth > 0) {
            $userTreeDTO = new UserTreeDTO($userTree);
            $user = $userTree->getUser();
            $userTreeDTO->setUser(new UserDTO($user));

            //Children
            $children = array();
            foreach ($userTree->getChildren() as $tree) {
                $transformedTree = $this->getTree($tree, $depth - 1);
                if ($transformedTree != null) {
                    array_push($children, $transformedTree);
                }
            }
            usort($children, array($this, "positionComparator"));
            $userTreeDTO->setChildren($children);

            //Counts
            $counts = array();
            foreach ($userTree->getUserPositions() as $count) {
                array_push($counts, new UserPositionDTO($count));
            }
            usort($counts, array($this, "positionComparator"));
            $userTreeDTO->setUserPositions($counts);

            //user balance
            $userBalance = DTOFactory::getUserBalanceDTO($user->getBalance());
            $userTreeDTO->getUser()->setBalance($userBalance);
            return $userTreeDTO;
        }
    }

    /**
     * Get the list of all referrals 
     * @param string $username
     * @return array
     */
    function getUserSmartTables(string $username) {
        $user = $this->daoFactory->getUserDAO()->getByUserName($username);
        $userTreeList = $this->daoFactory->getUserTreeDAO()->findByUser($user);
        return $this->convertToUserTreeDTOList($userTreeList);
    }

    /**
     * Get the list of all referrals 
     * @param string $username
     * @return array
     */
    function getUserGlobleTables(string $username) {
        $user = $this->daoFactory->getUserDAO()->getByUserName($username);
        $userTreeList = $this->daoFactory->getUserTreeDAO()->findGrowthTableByUser($user);
        return $this->convertToUserTreeDTOList($userTreeList);
    }

    /**
     * Get direct referral list of user
     * @param User $user
     * @return array
     */
    function getDirectReferralList(User $user) {
        $userTreeDTOList = [];
        $userTreeList = $this->daoFactory->getUserTreeDAO()->findByOwner($user);
        foreach ($userTreeList as $tree) {
            $userTreeDTO = $this->convertToUserTreeDTO($tree);
            if ($userTreeDTO != null && $userTreeDTO->getLevel() == TreeConstant::LEVEL_FIRST) {
                array_push($userTreeDTOList, $userTreeDTO);
            }
        }
        return $userTreeDTOList;
    }

    /**
     * Get refferal list of team
     * @param UserTree $userTree
     * @return array
     */
    function getTeamReferralList(?UserTree $userTree) {
        $userTreeDTOList = [];
        if ($userTree != null) {
            $userTreeDTO = $this->convertToUserTreeDTO($userTree);
            array_push($userTreeDTOList, $userTreeDTO);
            foreach ($userTree->getChildren() as $tree) {
                array_push($userTreeDTOList, ...$this->getTeamReferralList($tree));
            }
        }
        return $userTreeDTOList;
    }

    /**
     * Get referral list of team
     * @param UserTree $userTree
     * @return array
     */
    function getReferralUserTree(UserTree $userTree, $depth) {
        if ($depth < 0) {
            return;
        }
        $userTreeDTO = $this->convertToUserTreeDTO($userTree);
        $childrenDTO = [];
        $children = $this->daoFactory->getUserTreeDAO()->findByOwner($userTree->getUser());
        foreach ($children as $tree) {
            $treeDTO = $this->getReferralUserTree($tree, $depth - 1);
            if ($treeDTO != null && $treeDTO->getLevel() == TreeConstant::LEVEL_FIRST) {
                array_push($childrenDTO, $treeDTO);
            }
        }
        $userTreeDTO->setChildren($childrenDTO);
        return $userTreeDTO;
    }

    private function convertToUserTreeDTO(UserTree $userTree) {
        $userTreeDTO = new UserTreeDTO($userTree);
        $userDTO = new UserDTO($userTree->getUser());
        $userDTO->setBalance(new UserBalanceDTO($userTree->getUser()->getBalance()));
        if ($userTree->getUser()->getPlan()) {
            $userService = new UserService($this->daoFactory);
            if ($userTree->getUser()->getBalance() != null) {
                $userDTO->getBalance()->setTeamBusinessVolume($userService->calculateTeamBusinessVolume($userTree));
            } else {
                $userDTO->getBalance()->setTeamBusinessVolume(0);
            }
            $userDTO->setPlan(new PlanDTO($userTree->getUser()->getPlan()));
        }
        $userTreeDTO->setUser($userDTO);
        return $userTreeDTO;
    }

    private function convertToUserTreeDTOList($userTreeList) {
        $userTreeDTOList = array();
        foreach ($userTreeList as $tree) {
            $treeDTO = new UserTreeDTO($tree);
            $treeDTO->setUser(new UserDTO($tree->getUser()));
            if ($tree->getParent() != null) {
                $parentTreeDTO = new UserTreeDTO($tree->getParent());
                $parentTreeDTO->setUser(new UserDTO($tree->getParent()->getUser()));
                $treeDTO->setParent($parentTreeDTO);
            }
            if ($tree->getOwner() != null) {
                $treeDTO->setOwner(new UserDTO($tree->getOwner()));
            }
            array_push($userTreeDTOList, $treeDTO);
        }
        return $userTreeDTOList;
    }

    function positionComparator($a, $b) {
        return strcmp($a->getPosition(), $b->getPosition());
    }

}
