<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="migration")
 * */
class Migration extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="migration") * */
    protected $migration;

    /** @Column(type="string", name="batch") * */
    protected $batch;

    function getId() {
        return $this->id;
    }

    function getMigration() {
        return $this->migration;
    }

    function getBatch() {
        return $this->batch;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setMigration($migration) {
        $this->migration = $migration;
    }

    function setBatch($batch) {
        $this->batch = $batch;
    }

}
