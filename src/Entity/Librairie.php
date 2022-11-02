<?php

namespace App\Entity;

use App\Repository\LibrairieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibrairieRepository::class)]
class Librairie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'librairie', targetEntity: Livre::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $livres;

    #[ORM\ManyToOne(inversedBy: 'librairie')]
    private ?Amateur $amateur = null;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
            $livre->setLibrairie($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getLibrairie() === $this) {
                $livre->setLibrairie(null);
            }
        }

        return $this;
    }

    public function getAmateur(): ?Amateur
    {
        return $this->amateur;
    }

    public function setAmateur(?Amateur $amateur): self
    {
        $this->amateur = $amateur;

        return $this;
    }

    public function __toString()
    {
        
        return $this-> description;

    }

}
