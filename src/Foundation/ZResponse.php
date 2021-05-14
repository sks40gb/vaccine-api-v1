<?php

use Slim\Http\Response;

class ZResponse extends Response {

  public function withJson($data, $status = null, $encodingOptions = 0) {
    /*if(!isset($data['error'])) {
      $data['error'] = false;
    }

    if(!isset($data['status'])) {
      $data['status'] = $status ?: $this->getStatusCode();
    }
    */
    return parent::withJson($data, $status, $encodingOptions);
  }

  public function withSuccess($message) {
      return $this->withJson(["message"=>$message]);
  }
  
  public function withJsonData($data) {
    return $this->withJson([
      'data' => $data
    ]);
  }
  
}