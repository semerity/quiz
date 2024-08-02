<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueRepository::class)]
class Historique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $id_user = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbBonneRep = null;

    #[ORM\Column(nullable: true)]
    private ?int $id_categorie = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbQuestion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(?int $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getNbBonneRep(): ?int
    {
        return $this->nbBonneRep;
    }

    public function setNbBonneRep(?int $nbBonneRep): static
    {
        $this->nbBonneRep = $nbBonneRep;

        return $this;
    }

    public function getIdCategorie(): ?int
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?int $id_categorie): static
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }

    public function getNbQuestion(): ?int
    {
        return $this->nbQuestion;
    }

    public function setNbQuestion(?int $nbQuestion): static
    {
        $this->nbQuestion = $nbQuestion;

        return $this;
    }
}
