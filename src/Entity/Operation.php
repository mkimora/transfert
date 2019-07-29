<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\OperationRepository")
 */
class Operation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $montantdeposer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $soldeAvantDepot;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDepot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Partenaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantdeposer(): ?string
    {
        return $this->montantdeposer;
    }

    public function setMontantdeposer(string $montantdeposer): self
    {
        $this->montantdeposer = $montantdeposer;

        return $this;
    }

    public function getSoldeAvantDepot(): ?string
    {
        return $this->soldeAvantDepot;
    }

    public function setSoldeAvantDepot(string $soldeAvantDepot): self
    {
        $this->soldeAvantDepot = $soldeAvantDepot;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->Partenaire;
    }

    public function setPartenaire(?Partenaire $Partenaire): self
    {
        $this->Partenaire = $Partenaire;

        return $this;
    }
}
