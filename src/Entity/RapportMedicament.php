<?php

namespace App\Entity;

use App\Repository\RapportMedicamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportMedicamentRepository::class)]
class RapportMedicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nombre = null;

    #[ORM\OneToMany(mappedBy: 'rapportMedicament', targetEntity: RapportVisite::class)]
    private Collection $raportvisite;

    #[ORM\OneToMany(mappedBy: 'rapportMedicament', targetEntity: Medicament::class)]
    private Collection $medicament;

    #[ORM\ManyToOne(inversedBy: 'medicament')]
    private ?RapportVisite $rapportvisite = null;

    #[ORM\ManyToOne(inversedBy: 'rapportMedicaments')]
    private ?Medicament $medicaments = null;

    public function __construct()
    {
        $this->raportvisite = new ArrayCollection();
        $this->medicament = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, RapportVisite>
     */
    public function getRaportvisite(): Collection
    {
        return $this->raportvisite;
    }

    public function addRaportvisite(RapportVisite $raportvisite): self
    {
        if (!$this->raportvisite->contains($raportvisite)) {
            $this->raportvisite->add($raportvisite);
            $raportvisite->setRapportMedicament($this);
        }

        return $this;
    }

    public function removeRaportvisite(RapportVisite $raportvisite): self
    {
        if ($this->raportvisite->removeElement($raportvisite)) {
            // set the owning side to null (unless already changed)
            if ($raportvisite->getRapportMedicament() === $this) {
                $raportvisite->setRapportMedicament(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Medicament>
     */
    public function getMedicament(): Collection
    {
        return $this->medicament;
    }

    public function addMedicament(Medicament $medicament): self
    {
        if (!$this->medicament->contains($medicament)) {
            $this->medicament->add($medicament);
            $medicament->setRapportMedicament($this);
        }

        return $this;
    }

    public function removeMedicament(Medicament $medicament): self
    {
        if ($this->medicament->removeElement($medicament)) {
            // set the owning side to null (unless already changed)
            if ($medicament->getRapportMedicament() === $this) {
                $medicament->setRapportMedicament(null);
            }
        }

        return $this;
    }

    public function getRapportvisite(): ?RapportVisite
    {
        return $this->rapportvisite;
    }

    public function setRapportvisite(?RapportVisite $rapportvisite): self
    {
        $this->rapportvisite = $rapportvisite;

        return $this;
    }

    public function getMedicaments(): ?Medicament
    {
        return $this->medicaments;
    }

    public function setMedicaments(?Medicament $medicaments): self
    {
        $this->medicaments = $medicaments;

        return $this;
    }
}
