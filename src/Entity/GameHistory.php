<?php

namespace App\Entity;

use App\Repository\GameHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameHistoryRepository::class)]
class GameHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $hero_id = null;

    #[ORM\Column]
    private ?int $reached_world = null;

    #[ORM\Column]
    private ?int $reached_stage = null;


    #[ORM\Column(length: 255)]
    private ?string $username = null;


    #[ORM\Column]
    private ?\DateTimeImmutable $started_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $finished_at = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getReachedWorld(): ?int
    {
        return $this->reached_world;
    }

    public function setReachedWorld(int $reached_world): static
    {
        $this->reached_world = $reached_world;

        return $this;
    }

    public function getReachedStage(): ?int
    {
        return $this->reached_stage;
    }

    public function setReachedStage(int $reached_stage): static
    {
        $this->reached_stage = $reached_stage;

        return $this;
    }


    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->started_at;
    }

    public function setStartedAt(\DateTimeImmutable $started_at): static
    {
        $this->started_at = $started_at;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeImmutable
    {
        return $this->finished_at;
    }

    public function setFinishedAt(\DateTimeImmutable $finished_at): static
    {
        $this->finished_at = $finished_at;

        return $this;
    }

   
    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }
}
