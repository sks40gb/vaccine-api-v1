<?php
namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Services\SettingService;

class SettingController extends BaseController {

    private $settingService;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->settingService = new SettingService($this->daoFactory);
    }

    public function get(Request $request, Response $response, array $args): Response {
        $type = $request->getAttribute("type");
        return $response->withJson($this->settingService->getSetting($type));
    }

    public function update(Request $request, Response $response, array $args): Response {
        $type = $request->getAttribute("type");
        $settings = $request->getParsedBody();
        return $response->withJson($this->settingService->updateSetting($type,$settings ));
    }

}
