<?php

namespace App\Entity;

use App\Repository\MedicamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicamentRepository::class)]
class Medicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'medicament')]
    private ?RapportMedicament $rapportMedicament = null;

    #[ORM\OneToMany(mappedBy: 'medicaments', targetEntity: RapportMedicament::class)]
    private Collection $rapportMedicaments;

    public function __construct()
    {
        $this->rapport_visite = new ArrayCollection();
        $this->rapportMedicaments = new ArrayCollection();
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

    public function getRapportMedicament(): ?RapportMedicament
    {
        return $this->rapportMedicament;
    }

    public function setRapportMedicament(?RapportMedicament $rapportMedicament): self
    {
        $this->rapportMedicament = $rapportMedicament;

        return $this;
    }

    /**
     * @return Collection<int, RapportMedicament>
     */
    public function getRapportMedicaments(): Collection
    {
        return $this->rapportMedicaments;
    }

    public function addRapportMedicament(RapportMedicament $rapportMedicament): self
    {
        if (!$this->rapportMedicaments->contains($rapportMedicament)) {
            $this->rapportMedicaments->add($rapportMedicament);
            $rapportMedicament->setMedicaments($this);
        }

        return $this;
    }

    public function removeRapportMedicament(RapportMedicament $rapportMedicament): self
    {
        if ($this->rapportMedicaments->removeElement($rapportMedicament)) {
            // set the owning side to null (unless already changed)
            if ($rapportMedicament->getMedicaments() === $this) {
                $rapportMedicament->setMedicaments(null);
            }
        }

        return $this;
    }

 }
