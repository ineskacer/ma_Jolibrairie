<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?int $annee_de_parution = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Librairie $librairie = null;

    #[ORM\ManyToOne(inversedBy: 'livre')]
    private ?Genre $genre = null;

    #[ORM\ManyToMany(targetEntity: Etalage::class, mappedBy: 'livres', cascade: ["persist"])]
    private Collection $etalages;

    public function __construct()
    {
        $this->etalages = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAnneeDeParution(): ?int
    {
        return $this->annee_de_parution;
    }

    public function setAnneeDeParution(int $annee_de_parution): self
    {
        $this->annee_de_parution = $annee_de_parution;

        return $this;
    }

    public function getLibrairie(): ?Librairie
    {
        return $this->librairie;
    }

    public function setLibrairie(?Librairie $librairie): self
    {
        $this->librairie = $librairie;

        return $this;
    }

    public function __toString()
    {
        
        return $this-> titre;

    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

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
            $etalage->addLivre($this);
        }

        return $this;
    }

    public function removeEtalage(Etalage $etalage): self
    {
        if ($this->etalages->removeElement($etalage)) {
            $etalage->removeLivre($this);
        }

        return $this;
    }


  
}
