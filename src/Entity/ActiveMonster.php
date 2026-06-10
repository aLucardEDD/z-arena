<?php

namespace App\Entity;

class ActiveMonster
{
    private string $name;
    private int $hp;
    private int $maxHp;
    private int $attack;
    private int $xpReward;
    private ?string $imagePath;
    private int $idTemplate;

    public function __construct(string $name, int $hp, int $attack, int $xpReward, ?string $imagePath = null, int $templateId)
    {
        $this->name = $name;
        $this->hp = $hp;
        $this->maxHp = $hp; 
        $this->attack = $attack;
        $this->xpReward = $xpReward;
        $this->imagePath = $imagePath;
        $this->templateId = $templateId;

    }
    public function getTemplateId(): int { 
        return $this->templateId; 
    }

    public function getName(): string { 
        return $this->name; 
    }
    
    public function getHp(): int { 
        return $this->hp; 
    }
    public function setHp(int $hp): void { 
        $this->hp = $hp; 
    }
    
    public function getMaxHp(): int { 
        return $this->maxHp; 
    }
    public function getAttack(): int { 
        return $this->attack; 
    }
    public function getXpReward(): int { 
        return $this->xpReward; 
    }
    public function getImagePath(): ?string { 
        return $this->imagePath; 
    }
}