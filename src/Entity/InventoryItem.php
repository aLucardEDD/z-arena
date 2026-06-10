<?php

namespace App\Entity;

use App\Repository\InventoryItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventoryItemRepository::class)]
class InventoryItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $quantity = 1;

    // Le lien vers le type d'objet (Senzu, Potion, etc.)
    #[ORM\ManyToOne(targetEntity: ItemTemplate::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?ItemTemplate $itemTemplate = null;

    // Le lien vers la partie en cours (si le héros meurt, l'item est supprimé en cascade)
    #[ORM\ManyToOne(targetEntity: PartieEnCours::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?PartieEnCours $partieEnCours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getItemTemplate(): ?ItemTemplate
    {
        return $this->itemTemplate;
    }

    public function setItemTemplate(?ItemTemplate $itemTemplate): static
    {
        $this->itemTemplate = $itemTemplate;
        return $this;
    }

    public function getPartieEnCours(): ?PartieEnCours
    {
        return $this->partieEnCours;
    }

    public function setPartieEnCours(?PartieEnCours $partieEnCours): static
    {
        $this->partieEnCours = $partieEnCours;
        return $this;
    }
}