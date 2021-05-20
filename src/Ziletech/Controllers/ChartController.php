<?php

namespace Ziletech\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Services\Chart\ChartService;
use Ziletech\Services\Common\TimeService;

class ChartController extends BaseController {

    public function getBarChart(Request $request, Response $response, array $args): Response {
        $param = $request->getParams();
        $chartService = new ChartService($this->daoFactory);
        $districtName = $param["districtName"];
        $startDate = TimeService::getDateForDatabase($param["startDate"]);
        $endDate = TimeService::getDateForDatabase($param["endDate"]);
        $result = $chartService->getBarChart($districtName, $startDate, $endDate);
        return $response->withJson($result);
    }



}
