<?php

namespace App\Entity;

use App\Repository\SimpleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SimpleRepository::class)]
class Simple
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\ManyToOne(targetEntity: Choix::class, inversedBy: 'simples')]
    #[ORM\JoinColumn(nullable: false)]
    private $choix;

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

    public function getChoix(): ?Choix
    {
        return $this->choix;
    }

    public function setChoix(?Choix $choix): self
    {
        $this->choix = $choix;

        return $this;
    }
}
