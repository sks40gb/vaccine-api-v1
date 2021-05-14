<?php

namespace Ziletech\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Services\Common\AutoCompleterService;

class AutocompleterController extends BaseController {

    public function findByQuery(Request $request, Response $response) {
        $queryName = $request->getAttribute("queryName");
        $searchText = $request->getAttribute("searchText");
        $dropdownService = new AutoCompleterService($this->daoFactory);
        $result = $dropdownService->findByQuery($queryName, $searchText);
        return $response->withJson(["status" => "OK", "results" => $result]);
    }

    public function findByTableAndColumn(Request $request, Response $response) {
        $table = $request->getAttribute("table");
        $column = $request->getAttribute("column");
        $searchText = $request->getAttribute("searchText");
        $dropdownService = new AutoCompleterService($this->daoFactory);
        $result = $dropdownService->findByTableAndColumn($table, $column, $searchText);
        return $response->withJson(["status" => "OK", "results" => $result]);
    }

}
