<?php

namespace Ziletech\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Database\DAO\ExecutionTrackerDAO;
use Ziletech\Database\DAO\GenericCodeDAO;
use Ziletech\Database\DAO\Property;
use Ziletech\Database\DTO\CenterDTO;
use Ziletech\Database\DTO\CentersDTO;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\DTOMapper;
use Ziletech\Database\DTO\SessionDTO;
use Ziletech\Database\Entity\Center;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\Session;
use Ziletech\Services\Common\TrackerService;

class CenterController extends BaseController {

    public function save(Request $request, Response $response, array $args): Response {
        $param = $request->getParams();
        $mapper = new DTOMapper();
        $centersDTO = $mapper->map($param, DTOFactory::getCentersDTO());
        $this->saveCenters($centersDTO);
        return $response->withJson($centersDTO);
    }

    public function saveFromThirdParty(Request $request, Response $response, array $args): Response {
        $trackerService = new TrackerService($this->daoFactory, ExecutionTrackerDAO::THIRD_PARTY_CENTER);
        $trackerService->autoCloseConnection();
        if($trackerService->getActiveTracker() == null){
            $trackerService->start();
            $mapper = new DTOMapper();
            $param = file_get_contents($this->getCentersUrl());
            $centersDTO = $mapper->mapString($param, DTOFactory::getCentersDTO());
            $this->saveCenters($centersDTO);
            $trackerService->close();
            return $response->withJson(["message"=> "Execution completed successfully."]);
        }
        return $response->withJson(["message"=> "Already running"]);
    }

    private function getCentersUrl():string{
        $filters = array();
        $codeType = $this->daoFactory->getCodeTypeDAO()->get(["description" => "SETTING"]);
        array_push($filters, Property::getInstance("codeType", $codeType->getId()));
        array_push($filters, Property::getInstance("code", GenericCodeDAO::VACCINE_CENTER_URL));
        $results = $this->daoFactory->getGenericCodeDAO()->filter($filters);
        $url =  $results[0]->getDescription();
        $url = str_replace("{{district_id}}", "265", $url);
        $url = str_replace("{{date}}", "17-05-2021", $url);
        return $url;
    }

    public function saveCenters(CentersDTO $centersDTO): void {
        foreach ($centersDTO->getCenters() as $centerDTO) {
            $center = $this->daoFactory->getCenterDAO()->getByCenterId($centerDTO->getCenterId());
            if ($center == null) {
                $center = EntityFactory::getCenter();
                $centerDTO->copyToDomain($center);
                $center = $this->daoFactory->getCenterDAO()->save($center);
            }
            $this->saveSessions($center, $centerDTO);
        }
    }

    private function saveSessions(Center $center, CenterDTO $centerDTO): void {
        foreach ($centerDTO->getSessions() as $sessionDTO) {
            if ($sessionDTO->getAvailableCapacity() != 0) {
                $this->closeSession($sessionDTO);
            } else {
                $this->saveSession($sessionDTO, $center);
            }
        }
    }

    private function closeSession(SessionDTO $sessionDTO) {
        $sessions = $this->daoFactory->getSessionDAO()->findOpenedSessions($sessionDTO->getSessionId());
        foreach ($sessions as $session) {
            $session->setClosedAt(new \DateTime());
            $session->setClosed(true);
            $this->daoFactory->getSessionDAO()->update($session);
        }
    }

    /**
     * @param SessionDTO $sessionDTO
     * @param Center $center
     */
    private function saveSession(SessionDTO $sessionDTO, Center $center): void {
        $sessions = $this->daoFactory->getSessionDAO()->findOpenedSessions($sessionDTO->getSessionId());
        if (sizeof($sessions) == 0) {
            $session = EntityFactory::getSession();
            $sessionDTO->copyToDomain($session);
            $session->setCenter($center);
            $session->setClosed(false);
            $session->setCreatedAt(new \DateTime());
            $this->daoFactory->getSessionDAO()->save($session);
            $this->saveSlots($session, $sessionDTO);
        }
    }

    private function saveSlots(Session $session, SessionDTO $sessionDTO): void {
        foreach ($sessionDTO->getSlots() as $time) {
            $slot = EntityFactory::getSlot();
            $slot->setSession($session);
            $slot->setDuration($time);
            $this->daoFactory->getSlotDAO()->save($slot);
        }
    }
}
