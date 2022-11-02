<?php

namespace App\Entity;

use App\Repository\AmateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AmateurRepository::class)]
class Amateur

{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'amateur', targetEntity: Librairie::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $librairie;

    public function __construct()
    {
        $this->librairie = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Librairie>
     */
    public function getLibrairie(): Collection
    {
        return $this->librairie;
    }

    public function addLibrairie(Librairie $librairie): self
    {
        if (!$this->librairie->contains($librairie)) {
            $this->librairie->add($librairie);
            $librairie->setAmateur($this);
        }

        return $this;
    }

    public function removeLibrairie(Librairie $librairie): self
    {
        if ($this->librairie->removeElement($librairie)) {
            // set the owning side to null (unless already changed)
            if ($librairie->getAmateur() === $this) {
                $librairie->setAmateur(null);
            }
        }

        return $this;
    }
}
