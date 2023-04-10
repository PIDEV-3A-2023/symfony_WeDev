<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_event", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_event", type="string", length=50, nullable=false)
     */
    private $nomEvent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_event", type="date", nullable=false)
     */
    private $dateEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="locate_event", type="string", length=50, nullable=false)
     */
    private $locateEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_event", type="string", length=255, nullable=false)
     */
    private $photoEvent;

    /**
     * @var int
     *
     * @ORM\Column(name="dispoplace_event", type="integer", nullable=false)
     */
    private $dispoplaceEvent;

    public function getIdEvent(): ?int
    {
        return $this->idEvent;
    }

    public function getNomEvent(): ?string
    {
        return $this->nomEvent;
    }

    public function setNomEvent(string $nomEvent): self
    {
        $this->nomEvent = $nomEvent;

        return $this;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $dateEvent): self
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getLocateEvent(): ?string
    {
        return $this->locateEvent;
    }

    public function setLocateEvent(string $locateEvent): self
    {
        $this->locateEvent = $locateEvent;

        return $this;
    }

    public function getPhotoEvent(): ?string
    {
        return $this->photoEvent;
    }

    public function setPhotoEvent(string $photoEvent): self
    {
        $this->photoEvent = $photoEvent;

        return $this;
    }

    public function getDispoplaceEvent(): ?int
    {
        return $this->dispoplaceEvent;
    }

    public function setDispoplaceEvent(int $dispoplaceEvent): self
    {
        $this->dispoplaceEvent = $dispoplaceEvent;

        return $this;
    }


}
