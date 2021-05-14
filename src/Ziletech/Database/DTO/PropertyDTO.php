<?php

namespace Ziletech\Database\DTO;

class PropertyDTO extends BaseDTO {

    public $name;
    public $value;
    public $active;

    function getName() {
        return $this->name;
    }

    function getValue() {
        return $this->value;
    }

    function getActive() {
        return $this->active;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setValue($value) {
        $this->value = $value;
    }

    function setActive($active) {
        $this->active = $active;
    }

}
