<?php

namespace App\Entity;

use App\Repository\RobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RobRepository::class)]
class Rob
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Travaux::class, inversedBy: 'robs')]
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
        }

        return $this;
    }

    public function removeTravaux(Travaux $travaux): static
    {
        $this->travaux->removeElement($travaux);

        return $this;
    }
}
