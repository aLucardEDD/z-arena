<?php

namespace App\Entity;

use App\Repository\PartieEnCoursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartieEnCoursRepository::class)]
class PartieEnCours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column]
    private ?int $hero_id = null;

    #[ORM\Column]
    private ?int $hp = null;

    #[ORM\Column]
    private ?int $max_hp = null;

    #[ORM\Column]
    private ?int $ki = null;

    #[ORM\Column]
    private ?int $max_ki = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\Column]
    private ?int $xp = null;

    #[ORM\Column]
    private ?int $corrent_world = null;

    #[ORM\Column]
    private ?int $current_stage = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getHeroId(): ?int
    {
        return $this->hero_id;
    }

    public function setHeroId(int $hero_id): static
    {
        $this->hero_id = $hero_id;

        return $this;
    }

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): static
    {
        $this->hp = $hp;

        return $this;
    }

    public function getMaxHp(): ?int
    {
        return $this->max_hp;
    }

    public function setMaxHp(int $max_hp): static
    {
        $this->max_hp = $max_hp;

        return $this;
    }

    public function getKi(): ?int
    {
        return $this->ki;
    }

    public function setKi(int $ki): static
    {
        $this->ki = $ki;

        return $this;
    }

    public function getMaxKi(): ?int
    {
        return $this->max_ki;
    }

    public function setMaxKi(int $max_ki): static
    {
        $this->max_ki = $max_ki;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getXp(): ?int
    {
        return $this->xp;
    }

    public function setXp(int $xp): static
    {
        $this->xp = $xp;

        return $this;
    }

    public function getCorrentWorld(): ?int
    {
        return $this->corrent_world;
    }

    public function setCorrentWorld(int $corrent_world): static
    {
        $this->corrent_world = $corrent_world;

        return $this;
    }

    public function getCurrentStage(): ?int
    {
        return $this->current_stage;
    }

    public function setCurrentStage(int $current_stage): static
    {
        $this->current_stage = $current_stage;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
