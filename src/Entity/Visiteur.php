<?php

namespace App\Entity;

use App\Repository\VisiteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VisiteurRepository::class)]
class Visiteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

   // #[ORM\ManyToMany(targetEntity: Region::class, inversedBy: 'visiteurs')]
   // private Collection $regions;

    #[ORM\Column(length: 20)]
    #[Assert\Email(message : ' e-mail not valid')]
    private ?string $tel = null;

    #[ORM\OneToMany(mappedBy: 'visiteur', targetEntity: RapportVisite::class)]
    private Collection $rapportVisites;

    #[ORM\OneToMany(mappedBy: 'visiteur', targetEntity: VisiteurRegion::class)]
    private Collection $visiteurRegions;

    public function __construct()
    {
        $this->visiteurregion = new ArrayCollection();
        $this->rapportVisites = new ArrayCollection();
        $this->visiteurRegions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom." ".$this->prenom;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, Region>
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegions(Region $regions): self
    {
        if (!$this->regions->contains($regions)) {
            $this->regions->add($regions);
        }

        return $this;
    }

    public function removeRegions(Region $regions): self
    {
        $this->regions->removeElement($regions);

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return Collection<int, RapportVisite>
     */
    public function getRapportVisites(): Collection
    {
        return $this->rapportVisites;
    }

    public function addRapportVisite(RapportVisite $rapportVisite): self
    {
        if (!$this->rapportVisites->contains($rapportVisite)) {
            $this->rapportVisites->add($rapportVisite);
            $rapportVisite->setVisiteur($this);
        }

        return $this;
    }

    public function removeRapportVisite(RapportVisite $rapportVisite): self
    {
        if ($this->rapportVisites->removeElement($rapportVisite)) {
            // set the owning side to null (unless already changed)
            if ($rapportVisite->getVisiteur() === $this) {
                $rapportVisite->setVisiteur(null);
            }
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
            $visiteurRegion->setVisiteur($this);
        }

        return $this;
    }

    public function removeVisiteurRegion(VisiteurRegion $visiteurRegion): self
    {
        if ($this->visiteurRegions->removeElement($visiteurRegion)) {
            // set the owning side to null (unless already changed)
            if ($visiteurRegion->getVisiteur() === $this) {
                $visiteurRegion->setVisiteur(null);
            }
        }

        return $this;
    }
}
