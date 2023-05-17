<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: Employe::class)]
    private Collection $employe;

   // #[ORM\ManyToMany(targetEntity: Visiteur::class, mappedBy: 'regions')]
   // private Collection $visiteurs;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: VisiteurRegion::class)]
    private Collection $visiteurRegions;

    public function __construct()
    {
        $this->employe = new ArrayCollection();
        $this->visiteurs = new ArrayCollection();
        $this->visiteurRegions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Employe>
     */
    public function getEmploye(): Collection
    {
        return $this->employe;
    }

    public function addEmploye(Employe $employe): self
    {
        if (!$this->employe->contains($employe)) {
            $this->employe->add($employe);
            $employe->setRegion($this);
        }

        return $this;
    }

    public function removeEmploye(Employe $employe): self
    {
        if ($this->employe->removeElement($employe)) {
            // set the owning side to null (unless already changed)
            if ($employe->getRegion() === $this) {
                $employe->setRegion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Visiteur>
     */
    public function getVisiteurs(): Collection
    {
        return $this->visiteurs;
    }

    public function addVisiteur(Visiteur $visiteur): self
    {
        if (!$this->visiteurs->contains($visiteur)) {
            $this->visiteurs->add($visiteur);
            $visiteur->addRegions($this);
        }

        return $this;
    }

    public function removeVisiteur(Visiteur $visiteur): self
    {
        if ($this->visiteurs->removeElement($visiteur)) {
            $visiteur->removeRegions($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, VisiteurRegion>
     */
    public function getVisiteurRegions(): Collection
    {
        return $this->visiteurRegions;
    }

    public function addVisiteurRegion(VisiteurRegion $visiteurRegion): self
    {
        if (!$this->visiteurRegions->contains($visiteurRegion)) {
            $this->visiteurRegions->add($visiteurRegion);
            $visiteurRegion->setRegion($this);
        }

        return $this;
    }

    public function removeVisiteurRegion(VisiteurRegion $visiteurRegion): self
    {
        if ($this->visiteurRegions->removeElement($visiteurRegion)) {
            // set the owning side to null (unless already changed)
            if ($visiteurRegion->getRegion() === $this) {
                $visiteurRegion->setRegion(null);
            }
        }

        return $this;
    }
}
