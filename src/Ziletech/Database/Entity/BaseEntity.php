<?php

/**
 * Description of Model
 *
 * @author sunsingh
 */

namespace Ziletech\Database\Entity;

class BaseEntity {

    public function __get($name) {

        #echo "Get:$name";
        return $this->$name;
    }

    public function __set($name, $value) {

        #echo "Set:$name to $value";
        $this->$name = $value;
    }

}
