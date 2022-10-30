<?php

namespace App\Entity;

use App\Repository\LivreRepository;
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
}
