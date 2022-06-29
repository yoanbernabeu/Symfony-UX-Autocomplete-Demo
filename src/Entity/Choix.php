<?php

namespace App\Entity;

use App\Repository\ChoixRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChoixRepository::class)]
class Choix
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\OneToMany(mappedBy: 'choix', targetEntity: Simple::class)]
    private $simples;

    #[ORM\ManyToMany(targetEntity: Multiple::class, mappedBy: 'Choix')]
    private $multiples;

    public function __construct()
    {
        $this->simples = new ArrayCollection();
        $this->multiples = new ArrayCollection();
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

    /**
     * @return Collection<int, Simple>
     */
    public function getSimples(): Collection
    {
        return $this->simples;
    }

    public function addSimple(Simple $simple): self
    {
        if (!$this->simples->contains($simple)) {
            $this->simples[] = $simple;
            $simple->setChoix($this);
        }

        return $this;
    }

    public function removeSimple(Simple $simple): self
    {
        if ($this->simples->removeElement($simple)) {
            // set the owning side to null (unless already changed)
            if ($simple->getChoix() === $this) {
                $simple->setChoix(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Multiple>
     */
    public function getMultiples(): Collection
    {
        return $this->multiples;
    }

    public function addMultiple(Multiple $multiple): self
    {
        if (!$this->multiples->contains($multiple)) {
            $this->multiples[] = $multiple;
            $multiple->addChoix($this);
        }

        return $this;
    }

    public function removeMultiple(Multiple $multiple): self
    {
        if ($this->multiples->removeElement($multiple)) {
            $multiple->removeChoix($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
