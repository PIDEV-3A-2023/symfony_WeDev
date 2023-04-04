<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeRec
 *
 * @ORM\Table(name="type_rec")
 * @ORM\Entity
 */
class TypeRec
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_type", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idType;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_rec", type="string", length=20, nullable=false)
     */
    private $etatRec;

    public function getIdType(): ?int
    {
        return $this->idType;
    }

    public function getEtatRec(): ?string
    {
        return $this->etatRec;
    }

    public function setEtatRec(string $etatRec): self
    {
        $this->etatRec = $etatRec;

        return $this;
    }


}
