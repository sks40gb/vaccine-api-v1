<?php

namespace Ziletech\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\BaseController;
use Ziletech\Services\InvoiceService;

class InvoiceController extends BaseController {

    public function generateInvoice(Request $request, Response $response, array $args) {
      $invoiceService = new InvoiceService($this->daoFactory);
      $invoiceService->printInvoice($args["userId"]);
    }

}
