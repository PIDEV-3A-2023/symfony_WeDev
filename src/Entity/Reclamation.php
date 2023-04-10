<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="reclamation_r1", columns={"IdUser"}), @ORM\Index(name="reclamation_r2", columns={"id_type"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_rec", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRec;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_rec", type="date", nullable=true)
     */
    private $dateRec;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_rec", type="string", length=255, nullable=true)
     */
    private $descriptionRec;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=30, nullable=false)
     */
    private $image;

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
     * @var \TypeRec
     *
     * @ORM\ManyToOne(targetEntity="TypeRec")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type", referencedColumnName="id_type")
     * })
     */
    private $idType;

    public function getIdRec(): ?int
    {
        return $this->idRec;
    }

    public function getDateRec(): ?\DateTimeInterface
    {
        return $this->dateRec;
    }

    public function setDateRec(?\DateTimeInterface $dateRec): self
    {
        $this->dateRec = $dateRec;

        return $this;
    }

    public function getDescriptionRec(): ?string
    {
        return $this->descriptionRec;
    }

    public function setDescriptionRec(?string $descriptionRec): self
    {
        $this->descriptionRec = $descriptionRec;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getIdType(): ?TypeRec
    {
        return $this->idType;
    }

    public function setIdType(?TypeRec $idType): self
    {
        $this->idType = $idType;

        return $this;
    }


}
