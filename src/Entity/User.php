<?php

namespace App\Entity;
use Doctrine\DBAL\Types\Types;
use repository;
use Doctrine\ORM\Mapping as ORM;
use App\repository\UserRecRepository;

#[ORM\Table(name: 'user')]
#[ORM\Entity(repositoryClass: UserRecRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'IdUser')]
    private int $iduser;

    #[ORM\Column(type: 'string', length: 20, name: 'NomUser')]
    private string $nomuser;

    #[ORM\Column(type: 'string', length: 30, name: 'PrenomUser')]
    private string $prenomuser;

    #[ORM\Column(type: 'date', name: 'DateNaiss')]
    private \DateTimeInterface $datenaiss;

    #[ORM\Column(type: 'string', length: 50, name: 'NumTel')]
    private string $numtel;

    #[ORM\Column(type: 'string', length: 50, name: 'Email')]
    private string $email;

    #[ORM\Column(type: 'string', length: 30, name: 'Adresse')]
    private string $adresse;

    #[ORM\Column(type: 'string', length: 1048, name: 'ImgUser')]
    private string $imguser;

    #[ORM\Column(type: 'string', length: 20, name: 'Mdp')]
    private string $mdp;

    #[ORM\Column(type: 'string', length: 20, name: 'Role')]
    private string $role;

    #[ORM\Column(type: 'integer', name: 'EtatCompte')]
    private int $etatcompte;

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function getNomuser(): ?string
    {
        return $this->nomuser;
    }

    public function setNomuser(string $nomuser): self
    {
        $this->nomuser = $nomuser;

        return $this;
    }

    public function getPrenomuser(): ?string
    {
        return $this->prenomuser;
    }

    public function setPrenomuser(string $prenomuser): self
    {
        $this->prenomuser = $prenomuser;

        return $this;
    }

    public function getDatenaiss(): ?\DateTimeInterface
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(\DateTimeInterface $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    public function getNumtel(): ?string
    {
        return $this->numtel;
    }

    public function setNumtel(string $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getImguser(): ?string
    {
        return $this->imguser;
    }

    public function setImguser(string $imguser): self
    {
        $this->imguser = $imguser;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getEtatcompte(): ?int
    {
        return $this->etatcompte;
    }

    public function setEtatcompte(int $etatcompte): self
    {
        $this->etatcompte = $etatcompte;

        return $this;
    }
}
