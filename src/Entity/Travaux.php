<?php

namespace App\Entity;

use App\Repository\TravauxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TravauxRepository::class)]
class Travaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $started_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $finished_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $rdv_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $commande = null;

    #[ORM\ManyToOne(inversedBy: 'travaux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    #[ORM\ManyToOne(inversedBy: 'travaux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Secteur $secteur = null;

    #[ORM\ManyToOne(inversedBy: 'travaux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $etat = null;

    #[ORM\ManyToMany(targetEntity: Rob::class, mappedBy: 'travaux')]
    private Collection $robs;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'travaux')]
    private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'travaux')]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: File::class, mappedBy: 'travaux', orphanRemoval: true)]
    private Collection $files;



    public function __construct()
    {
        $this->robs = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->files = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->started_at;
    }

    public function setStartedAt(?\DateTimeImmutable $started_at): static
    {
        $this->started_at = $started_at;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeImmutable
    {
        return $this->finished_at;
    }

    public function setFinishedAt(?\DateTimeImmutable $finished_at): static
    {
        $this->finished_at = $finished_at;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getRdvAt(): ?\DateTimeImmutable
    {
        return $this->rdv_at;
    }

    public function setRdvAt(?\DateTimeImmutable $rdv_at): static
    {
        $this->rdv_at = $rdv_at;

        return $this;
    }

    public function getCommande(): ?int
    {
        return $this->commande;
    }

    public function setCommande(?int $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }

    public function setSecteur(?Secteur $secteur): static
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Rob>
     */
    public function getRobs(): Collection
    {
        return $this->robs;
    }

    public function addRob(Rob $rob): static
    {
        if (!$this->robs->contains($rob)) {
            $this->robs->add($rob);
            $rob->addTravaux($this);
        }

        return $this;
    }

    public function removeRob(Rob $rob): static
    {
        if ($this->robs->removeElement($rob)) {
            $rob->removeTravaux($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTravaux($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTravaux() === $this) {
                $comment->setTravaux(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, File>
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): static
    {
        if (!$this->files->contains($file)) {
            $this->files->add($file);
            $file->setTravaux($this);
        }

        return $this;
    }

    public function removeFile(File $file): static
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getTravaux() === $this) {
                $file->setTravaux(null);
            }
        }

        return $this;
    }

    

   
}
