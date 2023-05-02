<?php

namespace App\Entity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationVeloRepository;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Table(name: "reservation_velo")]
#[ORM\Entity(repositoryClass: ReservationVeloRepository::class)]
class ReservationVelo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", name: "id_reservation")]
    private ?int $idReservation = null;

    
    #[ORM\Column(type: "datetime", name: "date_debut", nullable: true)]
    #[Assert\NotBlank]
    
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: "datetime", name: "date_fin", nullable: true)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(type: "integer", name: "nbr", options: ["default" => 1])]
    #[Assert\Positive]
    private int $nbr = 1;

    #[ORM\Column(type: "float", name: "prixr")]
    private float $prixr = 0;

    #[ORM\ManyToOne(targetEntity: Velo::class)]
    #[ORM\JoinColumn(name: "id_velo", referencedColumnName: "id_velo")]
    private ?Velo $idVelo = null;

    #[ORM\ManyToOne(targetEntity: Station::class)]
    #[ORM\JoinColumn(name: "id_station", referencedColumnName: "id_station")]
    private ?Station $idStation = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "iduser", referencedColumnName: "IdUser")]
    private ?User $iduser = null;

    // Getters and setters

    public function getIdReservation(): ?int
    {
        return $this->idReservation;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNbr(): int
    {
        return $this->nbr;
    }

    public function setNbr(int $nbr): self
    {
        $this->nbr = $nbr;

        return $this;
    }

    public function getPrixr(): float
    {
        return $this->prixr;
    }

    public function setPrixr(float $prixr): self
    {
        $this->prixr = $prixr;

        return $this;
    }

    public function getIdVelo(): ?Velo
    {
        return $this->idVelo;
    }

    public function setIdVelo(?Velo $idVelo): self
    {
        $this->idVelo = $idVelo;

        return $this;
    }

    public function getIdStation(): ?Station
    {
        return $this->idStation;
    }

    public function setIdStation(?Station $idStation): self
    {
        $this->idStation = $idStation;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->iduser;
    }

    public function setIdUser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }
}
