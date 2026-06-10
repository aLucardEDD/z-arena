<?php

namespace App\Entity;

use App\Repository\UserStatsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserStatsRepository::class)]
class UserStats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'userStats', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

   #[ORM\Column(options: ["default" => 0])]
    private int $boostPv = 0;

    #[ORM\Column(options: ["default" => 0])]
    private int $boostKi = 0;

    #[ORM\Column(options: ["default" => 0])]
    private int $boostAttack = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBoostPv(): int
    {
        return $this->boostPv;
    }

    public function setBoostPv(int $boostPv): static
    {
        $this->boostPv = $boostPv;

        return $this;
    }

    public function getBoostKi(): int
    {
        return $this->boostKi;
    }

    public function setBoostKi(int $boostKi): static
    {
        $this->boostKi = $boostKi;

        return $this;
    }

    public function getBoostAttack(): int
    {
        return $this->boostAttack;
    }

    public function setBoostAttack(int $boostAttack): static
    {
        $this->boostAttack = $boostAttack;

        return $this;
    }

    public function __construct()
    {
        $this->boostPv = 0;
        $this->boostKi = 0;
        $this->boostAttack = 0;
    }
}
