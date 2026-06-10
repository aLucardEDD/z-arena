<?php

namespace App\Entity;

use App\Repository\HeroTemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeroTemplateRepository::class)]
class HeroTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $base_hp = null;

    #[ORM\Column]
    private ?int $base_ki = null;

    #[ORM\Column(length: 255)]
    private ?string $image_path = null;

    #[ORM\Column]
    private ?int $attack = null;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'hero')]
    private Collection $skills;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
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

    public function getBaseHp(): ?int
    {
        return $this->base_hp;
    }

    public function setBaseHp(int $base_hp): static
    {
        $this->base_hp = $base_hp;

        return $this;
    }

    public function getBaseKi(): ?int
    {
        return $this->base_ki;
    }

    public function setBaseKi(int $base_ki): static
    {
        $this->base_ki = $base_ki;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->image_path;
    }

    public function setImagePath(string $image_path): static
    {
        $this->image_path = $image_path;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): static
    {
        $this->attack = $attack;

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        $this->skills->removeElement($skill);

        return $this;
    }
}

