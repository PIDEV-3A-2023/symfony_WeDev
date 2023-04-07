<?php

namespace App\Entity;
use Doctrine\DBAL\Types\Types;
use repository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EventRepository;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $idEvent = null;

    #[ORM\Column(type: 'string', length: 50)]
    private string $nomEvent;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $dateEvent;

    #[ORM\Column(type: 'string', length: 50)]
    private string $locateEvent;

    #[ORM\Column(type: 'string', length: 255)]
    private string $photoEvent;

    #[ORM\Column(type: 'integer')]
    private int $dispoplaceEvent;

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
