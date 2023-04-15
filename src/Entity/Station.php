<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\StationRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: StationRepository::class)]
#[UniqueEntity('nomStation',"Cette valeur est déjà utilisée, Le champ \"nom de la station\" ne doit pas être répété.")]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $idStation = null;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 7,
        max: 30,
        minMessage: 'Le nom de station doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Le nom de station ne peut pas dépasser {{ limit }} caractères',
    )]
    private string $nomStation;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\NotBlank]
    private string $localisationStation;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    private int $veloStation;

    // Constructor, getters, and setters
    // ...

    public function getIdStation(): ?int
    {
        return $this->idStation;
    }
    public function setIdStation(?Station $station): void
{
    $this->idStation = $station;
}



    public function getNomStation(): ?string
    {
        return $this->nomStation;
    }

    public function setNomStation(string $nomStation): self
    {
        $this->nomStation = $nomStation;

        return $this;
    }

    public function getLocalisationStation(): ?string
    {
        return $this->localisationStation;
    }

    public function setLocalisationStation(string $localisationStation): self
    {
        $this->localisationStation = $localisationStation;

        return $this;
    }

    public function getVeloStation(): ?int
    {
        return $this->veloStation;
    }

    public function setVeloStation(int $veloStation): self
    {
        $this->veloStation = $veloStation;

        return $this;
    }

    public function __toString()
    {
        return $this->nomStation; // assuming that the Station entity has a 'name' property
    }
}
