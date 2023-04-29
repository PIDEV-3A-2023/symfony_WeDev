<?php

namespace App\Entity;
use repository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservRepository;


#[ORM\Table(name: "reserv")]
#[ORM\Entity(repositoryClass: ReservRepository::class)]
class Reserv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", name: "id_res")]
    private ?int $idRes = null;

    #[ORM\ManyToOne(targetEntity: "Event")]

        #[ORM\JoinColumn(name: "id_event", referencedColumnName: "id_event")]
    private ?Event $idEvent = null;

    #[ORM\ManyToOne(targetEntity: "User")]

        #[ORM\JoinColumn(name: "IdUser", referencedColumnName: "IdUser")]
    private ?User $user = null;

    // Getters and setters

    public function getIdRes(): ?int
    {
        return $this->idRes;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setIdUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function __toString()
    {
        return $this->idRes; // assuming that the Station entity has a 'name' property
    }

    public function getIdEvent(): ?Event
    {
        return $this->idEvent;
    }

    public function setIdEvent(?Event $idEvent): self
    {
        $this->idEvent = $idEvent;

        return $this;
    }
}
