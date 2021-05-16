<?php

namespace Ziletech\Database\DTO;

class CentersDTO {

    /**
     * @var CenterDTO[]
     */
    public $centers = [];

    public $XDEBUG_SESSION_START;

    /**
     * @return CenterDTO[]
     */
    public function getCenters(): array {
        return $this->centers;
    }

    /**
     * @param CenterDTO[] $centers
     */
    public function setCenters(array $centers): void {
        $this->centers = $centers;
    }


}
