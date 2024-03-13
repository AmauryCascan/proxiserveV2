<?php

namespace App\Entity;

use App\Repository\SecteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SecteurRepository::class)]
class Secteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Travaux::class, mappedBy: 'secteur')]
    private Collection $travaux;

    public function __construct()
    {
        $this->travaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
    public function __toString(): string
    {
        return $this->name;
    }
    /**
     * @return Collection<int, Travaux>
     */
    public function getTravaux(): Collection
    {
        return $this->travaux;
    }

    public function addTravaux(Travaux $travaux): static
    {
        if (!$this->travaux->contains($travaux)) {
            $this->travaux->add($travaux);
            $travaux->setSecteur($this);
        }

        return $this;
    }

    public function removeTravaux(Travaux $travaux): static
    {
        if ($this->travaux->removeElement($travaux)) {
            // set the owning side to null (unless already changed)
            if ($travaux->getSecteur() === $this) {
                $travaux->setSecteur(null);
            }
        }

        return $this;
    }
}
