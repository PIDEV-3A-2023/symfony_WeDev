<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reserv
 *
 * @ORM\Table(name="reserv", indexes={@ORM\Index(name="reserv_rr_1", columns={"IdUser"}), @ORM\Index(name="reservation_rr_2", columns={"id_event"})})
 * @ORM\Entity
 */
class Reserv
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_res", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRes;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdUser", referencedColumnName="IdUser")
     * })
     */
    private $iduser;

    /**
     * @var \Event
     *
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_event", referencedColumnName="id_event")
     * })
     */
    private $idEvent;

    public function getIdRes(): ?int
    {
        return $this->idRes;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

public function setIdUser(User $user): self
{
    $this->iduser = $user;

    return $this;
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
