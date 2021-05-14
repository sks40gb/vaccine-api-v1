<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Services\SiteSettingService;

class SiteSettingController extends BaseController {

    private $siteSettingService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->siteSettingService = new SiteSettingService($this->daoFactory);
    }

    public function get(Request $request, Response $response, array $args) {
        $basicSetting = $this->daoFactory->getBasicSettingDAO()->findById($args['id']);
        return $response->withJson($this->siteSettingService->convertToBasicSettingDTO($basicSetting));
    }

    public function save(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $basicSettingDTO = $this->mapper->map($param, DTOFactory::getBasicSettingDTO());
        return $response->withJson($this->siteSettingService->saveBasicSetting($basicSettingDTO));
    }

    public function update(Request $request, Response $response, array $args) {
        $param = $request->getParams();
        $basicSettingDTO = $this->mapper->map($param, DTOFactory::getBasicSettingDTO());
        return $response->withJson($this->siteSettingService->updateBasicSetting($basicSettingDTO));
    }

    public function search(Request $request, Response $response, array $args) {
        return $response->withJson($this->siteSettingService->search());
    }
    public function getGeneralSetting(Request $request, Response $response, array $args) {
        return $response->withJson($this->siteSettingService->getGeneralSetting());
    }

    public function remove(Request $request, Response $response, array $args) {
        $this->siteSettingService->remove($args["id"]);
        return $response->withSuccess("Delete succesfully");
    }

}
