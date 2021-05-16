<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\Slot;

class SlotDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $duration;

    /**
     * @var string
     */
    public $session;


    public function __construct(Slot $slot = null) {
        if (isset($slot)) {
            $this->copyFromDomain($slot);
        }
    }

    public function copyFromDomain(Slot $slot) {
        $this->id = $slot->getId();
        $this->duration = $slot->getDuration();
        $this->session = $slot->getSession();
    }

    public function copyToDomain(Slot $slot) {
        $slot->setId($this->id);
        $slot->setDuration($this->duration);
        $slot->setSession($this->session);
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDuration(): string {
        return $this->duration;
    }

    /**
     * @param string $duration
     */
    public function setDuration(string $duration): void {
        $this->duration = $duration;
    }

    /**
     * @return string
     */
    public function getSession(): string {
        return $this->session;
    }

    /**
     * @param string $session
     */
    public function setSession(string $session): void {
        $this->session = $session;
    }
}
