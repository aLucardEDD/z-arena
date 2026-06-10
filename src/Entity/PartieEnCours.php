<?php

namespace App\Entity;

use App\Repository\PartieEnCoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?int $current_world = null;

    #[ORM\Column]
    private ?int $current_stage = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?int $attack = null;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'partieEnCours')]
    private Collection $skills;

    #[ORM\OneToOne(inversedBy: 'partieEnCours', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->inventory = new ArrayCollection();
    }

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

    public function getCurrentWorld(): ?int
    {
        return $this->current_world;
    }

    public function setCurrentWorld(int $current_world): static
    {
        $this->current_world = $current_world;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getName(): ?string { 

        return $this->name; 

    }
    public function setName(string $name): static 
    { 
        $this->name = $name; 
        return $this; 
    }

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagePath = null;



    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = $imagePath;
        return $this;
    }
    public function addXp(int $xpEarned): bool
    {
        $this->xp += $xpEarned;
        
        $xpRequired = $this->level * 50; 
        $hasLeveledUp = false;

        if ($this->xp >= $xpRequired) {
            $this->level += 1;
            $this->xp -= $xpRequired; 
            $hasLeveledUp = true;

            $this->gainLevelUpStats();
        }
        
        return $hasLeveledUp;
    }

    public function gainLevelUpStats(): void
    {
        // Ajuste ces valeurs selon l'équilibrage de ton jeu
        $this->max_hp += 20;
        $this->hp += 50; // Soigne le héros en montant de niveau
        
        $this->max_ki += 10;
        $this->ki += 25;
        
        $this->attack += 5;
    }

   
}
