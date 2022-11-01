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

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'amateur', targetEntity: Librairie::class)]
    private Collection $librairies;

    public function __construct()
    {
        $this->librairies = new ArrayCollection();
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Librairie>
     */
    public function getLibrairies(): Collection
    {
        return $this->librairies;
    }

    public function addLibrairy(Librairie $librairy): self
    {
        if (!$this->librairies->contains($librairy)) {
            $this->librairies->add($librairy);
            $librairy->setAmateur($this);
        }

        return $this;
    }

    public function removeLibrairy(Librairie $librairy): self
    {
        if ($this->librairies->removeElement($librairy)) {
            // set the owning side to null (unless already changed)
            if ($librairy->getAmateur() === $this) {
                $librairy->setAmateur(null);
            }
        }

        return $this;
    }
}
