<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Database\Entity\User;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\GenelogyService;

class GenelogyController extends BaseController {

    protected $genelogyService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->genelogyService = new GenelogyService($this->daoFactory);
    }

    public function getUserSmartTables(Request $request, Response $response, array $args) {
        $username = $this->getUser($request)->getUserName();
        $userTreeDTOList = $this->genelogyService->getUserSmartTables($username);
        return $response->withJson($userTreeDTOList);
    }

    public function getGlobalUserTables(Request $request, Response $response, array $args) {
        $username = $this->getUser($request)->getUserName();
        $userTreeDTOList = $this->genelogyService->getUserGlobleTables($username);
        return $response->withJson($userTreeDTOList);
    }

    public function getGlobalAdminTables(Request $request, Response $response, array $args) {
        $userTreeDTOList = $this->genelogyService->getUserGlobleTables($args["username"]);
        return $response->withJson($userTreeDTOList);
    }

    public function getGlobalUserTree(Request $request, Response $response, array $args) {
        $user = $this->getUser($request);
        $depth = $request->getAttribute("depth");
        $level = $request->getAttribute("level");
        return $response->withJson($this->getGlobalTree($user, $level, $depth));
    }
    public function getUplineGlobalTree(Request $request, Response $response, array $args) {
        $user = $this->daoFactory->getUserDAO()->getByUserName($args["username"]);
        $level = $request->getAttribute("level");
        return $response->withJson($this->getGlobalTree($user, $level, 20));
    }

    public function getAdminGlobalUserTree(Request $request, Response $response, array $args) {
        $user = $this->daoFactory->getUserDAO()->getByUserName($args["username"]);
        $depth = $request->getAttribute("depth");
        $level = $request->getAttribute("level");
        return $response->withJson($this->getGlobalTree($user, $level, $depth));
    }

    private function getGlobalTree(User $user, $level, $depth) {
        $type = 1;
        $userTree = $this->daoFactory->getUserTreeDAO()->getByUserAndLevel($user, $level, $type);
        $tree = [];
        if ($userTree != null) {
            //throw new ZiletechException("There is no entry of user {$user->getId()} in User Tree.");
            $tree = $this->genelogyService->getTree($userTree, $depth);
        }
        return $tree;
    }

    public function getUserTree(Request $request, Response $response, array $args) {
        $user = $this->getUser($request);
        $level = $request->getAttribute("level");
        $depth = $request->getAttribute("depth");
        $userTree = $this->daoFactory->getUserTreeDAO()->getByUserAndLevel($user, $level);
        if ($userTree == null) {
            throw new ZiletechException("There is no entry of user {$user->getId()} in User Tree.");
        }
        $tree = $this->genelogyService->getTree($userTree, $depth);
        return $response->withJson($tree);
    }

    public function getMultipleUserTree(Request $request, Response $response, array $args) {
        $user = $this->getCurrentUser($request);
        $userTreeArray = $this->daoFactory->getUserTreeDAO()->findByUser($user);
        $depth = $request->getAttribute("depth");
        $treeList = array();
        foreach ($userTreeArray as $userTree) {
            $tree = $this->genelogyService->getTree($userTree, $depth);
            array_push($treeList, [$tree]);
        }
        return $response->withJson($treeList);
    }

    public function getDirectReferralList(Request $request, Response $response, array $args) {
        $user = $this->getUser($request);
        //$userTree = $this->daoFactory->getUserTreeDAO()->getByUserAndLevel($user, 1);
        $userTreeDTOList = $this->genelogyService->getDirectReferralList($user);
        return $response->withJson($userTreeDTOList);
    }

    public function getTeamReferralList(Request $request, Response $response, array $args) {
        $user = $this->getUser($request);
        $userTree = $this->daoFactory->getUserTreeDAO()->getByUserAndLevel($user, 1);
        $userTreeDTOList = $this->genelogyService->getTeamReferralList($userTree);
        return $response->withJson($userTreeDTOList);
    }

    public function getReferralUserTree(Request $request, Response $response, array $args) {
        $user = $this->getUser($request);
        $depth = $request->getAttribute("depth");
        $userTree = $this->daoFactory->getUserTreeDAO()->getByUserAndLevel($user, 1);
        $userTreeDTOList = $this->genelogyService->getReferralUserTree($userTree, $depth);
        return $response->withJson($userTreeDTOList);
    }
    public function getReferralUserTreeByUserName(Request $request, Response $response, array $args) {
        $user = $this->daoFactory->getUserDAO()->getByUserName($request->getAttribute("username"));
        $depth = $request->getAttribute("depth");
        $userTree = $this->daoFactory->getUserTreeDAO()->getByUserAndLevel($user, 1);
        $userTreeDTOList = $this->genelogyService->getReferralUserTree($userTree, $depth);
        return $response->withJson($userTreeDTOList);
    }

    function getUser($request) {
        $user = $this->getCurrentUser($request);
        if ($user == null) {
            throw new ZiletechException("No user is found with username $username");
        }
        return $user;
    }

}
