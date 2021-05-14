<?php

namespace Ziletech\Controllers;

use Ziletech\Exceptions\ZiletechException;

class GenelogyAdminController extends GenelogyController {

    function getUser($request) {
        $username = $request->getAttribute("username");
        $user = $this->daoFactory->getUserDAO()->getByUserName($username);
        if ($user == null) {
            throw new ZiletechException("No user is found with username $username");
        }
        return $user;
    }

}
