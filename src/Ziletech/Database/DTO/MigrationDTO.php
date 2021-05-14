<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\Migration;

class MigrationDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $batch;

    /**
     * @var string
     */
    public $migration;

    public function __construct(Migration $migration = null) {
        if (isset($migration)) {
            $this->copyFromDomain($migration);
        }
    }

    public function copyFromDomain($migration) {
        $this->id = $migration->id;
        $this->migration = $migration->migration;
        $this->batch = $migration->batch;
    }

    public function copyToDomain($migration) {
        $migration->id = $this->id;
        $migration->migration = $this->migration;
        $migration->batch = $this->batch;
    }

    function getId() {
        return $this->id;
    }

    function getBatch() {
        return $this->batch;
    }

    function getMigration() {
        return $this->migration;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setBatch($batch) {
        $this->batch = $batch;
    }

    function setMigration($migration) {
        $this->migration = $migration;
    }

}
