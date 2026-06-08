<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $identifiant = null;

    #[ORM\Column]
    private ?int $ki_cost = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $niveau_requis = null;

    #[ORM\Column]
    private ?int $damage = null;

    /**
     * @var Collection<int, HeroTemplate>
     */
    #[ORM\ManyToMany(targetEntity: HeroTemplate::class, mappedBy: 'skills')]
    private Collection $hero;

    public function __construct()
    {
        $this->hero = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): static
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getKiCost(): ?int
    {
        return $this->ki_cost;
    }

    public function setKiCost(int $ki_cost): static
    {
        $this->ki_cost = $ki_cost;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getNiveauRequis(): ?int
    {
        return $this->niveau_requis;
    }

    public function setNiveauRequis(int $niveau_requis): static
    {
        $this->niveau_requis = $niveau_requis;

        return $this;
    }

    public function getDamage(): ?int
    {
        return $this->damage;
    }

    public function setDamage(int $damage): static
    {
        $this->damage = $damage;

        return $this;
    }

    /**
     * @return Collection<int, HeroTemplate>
     */
    public function getHero(): Collection
    {
        return $this->hero;
    }

    public function addHero(HeroTemplate $hero): static
    {
        if (!$this->hero->contains($hero)) {
            $this->hero->add($hero);
            $hero->addSkill($this);
        }

        return $this;
    }

    public function removeHero(HeroTemplate $hero): static
    {
        if ($this->hero->removeElement($hero)) {
            $hero->removeSkill($this);
        }

        return $this;
    }
}
