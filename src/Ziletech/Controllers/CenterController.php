<?php

namespace Ziletech\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Database\DTO\CenterDTO;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\DTOMapper;
use Ziletech\Database\DTO\SessionDTO;
use Ziletech\Database\Entity\Center;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\Session;

class CenterController extends BaseController {

    public function save(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $mapper = new DTOMapper();

        $centersDTO = $mapper->map($param, DTOFactory::getCentersDTO());

        foreach ($centersDTO->getCenters() as $centerDTO) {
            $center = $this->daoFactory->getCenterDAO()->getByCenterId($centerDTO->getCenterId());
            if ($center == null) {
                $center = EntityFactory::getCenter();
                $centerDTO->copyToDomain($center);
                $center = $this->daoFactory->getCenterDAO()->save($center);
            }
            $this->saveSession($center, $centerDTO);

        }
        return $response->withJson($centersDTO);
    }

    private function saveSession(Center $center, CenterDTO $centerDTO): void {
        foreach ($centerDTO->getSessions() as $sessionDTO) {
            $session = $this->daoFactory->getSessionDAO()->getBySessionId($sessionDTO->getSessionId());
            if ($session == null) {
                $session = EntityFactory::getSession();
                $sessionDTO->copyToDomain($session);
                $session->setCenter($center);
                $session->setCreatedAt(new \DateTime());
                $this->daoFactory->getSessionDAO()->save($session);
                $this->saveSlot($session, $sessionDTO);
            }
        }
    }

    private function saveSlot(Session $session, SessionDTO $sessionDTO): void {
        foreach ($sessionDTO->getSlots() as $time){
            $slot = EntityFactory::getSlot();
            $slot->setSession($session);
            $slot->setDuration($time);
            $this->daoFactory->getSlotDAO()->save($slot);
        }
    }
}