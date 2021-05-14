<?php

namespace Ziletech\Database\DTO;

use DateTime;
use JsonSerializable;
use Ziletech\Util\DateUtil;

class BaseDTO implements JsonSerializable {

    public  function jsonSerialize() {
        $json = array();
        foreach ($this as $key => $value) {
            if ($value instanceof DateTime) {
                $json[$key] = DateUtil::formatDate($value);
            } else {
                $json[$key] = $value;
            }
        }
        return $json; // or json_encode($json)
    }

}