<?php

namespace Ziletech\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Database\DAO\ExecutionTrackerDAO;
use Ziletech\Database\DAO\GenericCodeDAO;
use Ziletech\Database\DTO\CenterDTO;
use Ziletech\Database\DTO\CentersDTO;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\DTOMapper;
use Ziletech\Database\DTO\SessionDTO;
use Ziletech\Database\Entity\Center;
use Ziletech\Database\Entity\CodeTypeConstant;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\Session;
use Ziletech\Services\Common\GenericCodeService;
use Ziletech\Services\Common\TimeService;
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
        $times = 0;
        while ($times < 20) {
            sleep(3);
            $times++;
            $trackerService = new TrackerService($this->daoFactory, ExecutionTrackerDAO::THIRD_PARTY_CENTER);
            $trackerService->autoCloseConnection();
            if (sizeof($trackerService->getActiveTrackers()) == 0) {
                $trackerService->start();
                $this->executeForDisticts();
                $trackerService->close();
                //return $response->withJson(["message" => "Execution completed successfully."]);
            }
        }
        return $response->withJson(["message" => "Execution completed successfully."]);
    }

    private function executeForDisticts(): void {
        $genericCodeService = new GenericCodeService($this->daoFactory);
        $disctictIds = $genericCodeService->getDescription(CodeTypeConstant::SETTING, GenericCodeDAO::DISTRICT_IDS);
        $disctictArray = explode(",", $disctictIds);
        foreach ($disctictArray as $distictId) {
            $this->executeForDistict($distictId);
        }
    }

    private function executeForDistict($distictId): void {
        $mapper = new DTOMapper();
        $param = file_get_contents($this->getCentersUrl($distictId));
        $centersDTO = $mapper->mapString($param, DTOFactory::getCentersDTO());
        $this->saveCenters($centersDTO);
    }

    private function getCentersUrl(string $distictId): string {
        $genericCodeService = new GenericCodeService($this->daoFactory);
        $url = $genericCodeService->getDescription(CodeTypeConstant::SETTING, GenericCodeDAO::VACCINE_CENTER_URL);
        $url = str_replace("{{district_id}}", $distictId, $url);
        $url = str_replace("{{date}}", date("d-m-y"), $url);
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
            if ($sessionDTO->getAvailableCapacity() == 0) {
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
            $seconds = TimeService::getDiffInSeconds($session->getCreatedAt(), $session->getClosedAt());
            $session->setBookingTime($seconds);
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
