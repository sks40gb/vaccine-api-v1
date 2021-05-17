<?php

namespace Ziletech\Database\DTO;

class DTOMapper {

    public function map($json, $dtoEntity) {
        $jsonEncoded = json_encode($json);
        return $this->mapString($jsonEncoded, $dtoEntity);
    }

    public function mapString(string $jsonEncoded, $dtoEntity) {
        $jsonDecoded = json_decode($jsonEncoded, false);
        $mapper = new \JsonMapper();
        $mapper->bStrictNullTypes = false;
        $mapper->bExceptionOnUndefinedProperty = true;
        $mapper->bExceptionOnMissingData = true;;
        if (is_array($jsonDecoded)) {
            return $mapper->mapArray($jsonDecoded, array(), get_class($dtoEntity));
        } else {
            return $mapper->map($jsonDecoded, $dtoEntity);
        }
    }

}
