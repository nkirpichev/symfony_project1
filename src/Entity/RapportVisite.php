<?php

namespace App\Entity;

use App\Repository\RapportVisiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportVisiteRepository::class)]
class RapportVisite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_visite = null;

    #[ORM\ManyToOne(inversedBy: 'rapportVisites')]
    private ?Visiteur $visiteur = null;

    #[ORM\ManyToOne(inversedBy: 'raportvisite')]
    private ?RapportMedicament $rapportMedicament = null;

    #[ORM\OneToMany(mappedBy: 'rapportvisite', targetEntity: RapportMedicament::class)]
    private Collection $medicament;

    public function __construct()
    {
        $this->medicaments = new ArrayCollection();
        $this->medicament = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->date_visite;
    }

    public function setDateVisite(\DateTimeInterface $date_visite): self
    {
        $this->date_visite = $date_visite;

        return $this;
    }

    public function getVisiteur(): ?Visiteur
    {
        return $this->visiteur;
    }

    public function setVisiteur(?Visiteur $visiteur): self
    {
        $this->visiteur = $visiteur;

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
    public function getMedicament(): Collection
    {
        return $this->medicament;
    }

    public function addMedicament(RapportMedicament $medicament): self
    {
        if (!$this->medicament->contains($medicament)) {
            $this->medicament->add($medicament);
            $medicament->setRapportvisite($this);
        }

        return $this;
    }

    public function removeMedicament(RapportMedicament $medicament): self
    {
        if ($this->medicament->removeElement($medicament)) {
            // set the owning side to null (unless already changed)
            if ($medicament->getRapportvisite() === $this) {
                $medicament->setRapportvisite(null);
            }
        }

        return $this;
    }

}
