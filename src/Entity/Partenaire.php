<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 */
class Partenaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"lister"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"lister"})
     */
    private $nompartenaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"lister"})
     */
    private $raisonSocial;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"lister"})
     */
    private $ninea;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"lister"})
     */
    private $numcompte;

    /**
     * @ORM\Column(type="bigint")
     * @Groups({"lister"})
     */
    private $solde;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"lister"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"lister"})
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="partenaires" )
     */
    private $createdby;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="partenaire")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Operation", mappedBy="Partenaire")
     */
    private $operations;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNompartenaire(): ?string
    {
        return $this->nompartenaire;
    }

    public function setNompartenaire(string $nompartenaire): self
    {
        $this->nompartenaire = $nompartenaire;

        return $this;
    }

    public function getRaisonSocial(): ?string
    {
        return $this->raisonSocial;
    }

    public function setRaisonSocial(?string $raisonSocial): self
    {
        $this->raisonSocial = $raisonSocial;

        return $this;
    }

    public function getNinea(): ?int
    {
        return $this->ninea;
    }

    public function setNinea(?int $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    public function getNumcompte(): ?int
    {
        return $this->numcompte;
    }

    public function setNumcompte(int $numcompte): self
    {
        $this->numcompte = $numcompte;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCreatedby(): ?User
    {
        return $this->createdby;
    }

    public function setCreatedby(?User $createdby): self
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setPartenaire($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getPartenaire() === $this) {
                $user->setPartenaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Operation[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations[] = $operation;
            $operation->setPartenaire($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getPartenaire() === $this) {
                $operation->setPartenaire(null);
            }
        }

        return $this;
    }

   
}
