<?php

namespace App\Entity;

use App\Repository\EnnemiesTemplateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnnemiesTemplateRepository::class)]
class EnnemiesTemplate
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
    private ?int $base_attack = null;

    #[ORM\Column]
    private ?int $xp_reward = null;

    #[ORM\Column(length: 255)]
    private ?string $image_path = null;

    #[ORM\Column]
    private ?bool $isBoss = null;

    #[ORM\Column]
    private ?bool $isSemiBoss = null;

    #[ORM\Column]
    private ?int $world = null;

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

    public function getBaseAttack(): ?int
    {
        return $this->base_attack;
    }

    public function setBaseAttack(int $base_attack): static
    {
        $this->base_attack = $base_attack;

        return $this;
    }

    public function getXpReward(): ?int
    {
        return $this->xp_reward;
    }

    public function setXpReward(int $xp_reward): static
    {
        $this->xp_reward = $xp_reward;

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

    public function isBoss(): ?bool
    {
        return $this->isBoss;
    }

    public function setIsBoss(bool $isBoss): static
    {
        $this->isBoss = $isBoss;

        return $this;
    }

    public function isSemiBoss(): ?bool
    {
        return $this->isSemiBoss;
    }

    public function setIsSemiBoss(bool $isSemiBoss): static
    {
        $this->isSemiBoss = $isSemiBoss;

        return $this;
    }

    public function getWorld(): ?int
    {
        return $this->world;
    }

    public function setWorld(int $world): static
    {
        $this->world = $world;

        return $this;
    }
}
