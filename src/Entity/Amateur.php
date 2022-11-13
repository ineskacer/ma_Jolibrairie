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

    #[ORM\OneToMany(mappedBy: 'amateur', targetEntity: Genre::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $genres;

    #[ORM\OneToMany(mappedBy: 'amateur', targetEntity: Etalage::class, cascade: ["persist"])]
    private Collection $etalages;


    public function __construct()
    {
        $this->librairie = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->étalages = new ArrayCollection();
        $this->etalages = new ArrayCollection();
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

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
            $genre->setAmateur($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genres->removeElement($genre)) {
            // set the owning side to null (unless already changed)
            if ($genre->getAmateur() === $this) {
                $genre->setAmateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Etalage>
     */
    public function getétalages(): Collection
    {
        return $this->étalages;
    }

    public function addTalage(Etalage $talage): self
    {
        if (!$this->étalages->contains($talage)) {
            $this->étalages->add($talage);
            $talage->setAmateur($this);
        }

        return $this;
    }

    public function removeTalage(Etalage $talage): self
    {
        if ($this->étalages->removeElement($talage)) {
            // set the owning side to null (unless already changed)
            if ($talage->getAmateur() === $this) {
                $talage->setAmateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Etalage>
     */
    public function getEtalages(): Collection
    {
        return $this->etalages;
    }

    public function addEtalage(Etalage $etalage): self
    {
        if (!$this->etalages->contains($etalage)) {
            $this->etalages->add($etalage);
            $etalage->setAmateur($this);
        }

        return $this;
    }

    public function removeEtalage(Etalage $etalage): self
    {
        if ($this->etalages->removeElement($etalage)) {
            // set the owning side to null (unless already changed)
            if ($etalage->getAmateur() === $this) {
                $etalage->setAmateur(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        
        return $this-> nom;

    }

}