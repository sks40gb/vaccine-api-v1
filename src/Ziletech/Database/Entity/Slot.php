<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity
 * @Table(name="slot")
 * */
class Slot extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="duration") * */
    protected $duration;

    /**
     * @ManyToOne(targetEntity="Session")
     * @JoinColumn(name="session_id", referencedColumnName="session_id")
     */
    protected $session;

    function __construct() {
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration): void {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getSession() {
        return $this->session;
    }

    /**
     * @param mixed $session
     */
    public function setSession($session): void {
        $this->session = $session;
    }


    public function __toString(): string {
        return "Slot[id: $this->id]";
    }

}
