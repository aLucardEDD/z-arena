<?php

namespace App\Controller\Admin;

use App\Entity\UserStats;
use App\Repository\GameHistoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class UserStatsCrudController extends AbstractCrudController
{
    private GameHistoryRepository $gameHistoryRepository;

    // 1. On injecte l'historique des parties via le constructeur
    public function __construct(GameHistoryRepository $gameHistoryRepository)
    {
        $this->gameHistoryRepository = $gameHistoryRepository;
    }

    public static function getEntityFqcn(): string
    {
        return UserStats::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('user', 'Joueur'),
            
            // Tes boosts permanents inchangés
            IntegerField::new('boostPv', 'Boost PV 🩸'),
            IntegerField::new('boostKi', 'Boost Ki ⚡'),
            IntegerField::new('boostAttack', 'Boost Attaque ⚔️'),
            


            IntegerField::new('gamesPlayedVirtual', 'Parties jouées 🎮')
                ->formatValue(function ($value, $entity) {
                    $user = $entity->getUser();
                    if (!$user) return 0;

                    // On utilise le username en texte pour correspondre à ta base de données
                    $username = $user->getUserIdentifier(); // ou ->getUsername() selon ta version de Symfony

                    return $this->gameHistoryRepository->count(['username' => $username]);
                }),

            TextField::new('highestFloorVirtual', 'Meilleur Record 🏆')
                ->formatValue(function ($value, $entity) {
                    $user = $entity->getUser();
                    if (!$user) return 'Aucune partie';

                    $username = $user->getUserIdentifier();

                    // On cherche avec 'username'
                    $bestGame = $this->gameHistoryRepository->findOneBy(
                        ['username' => $username], 
                        [
                            'reached_world' => 'DESC', 
                            'reached_stage' => 'DESC'
                        ] 
                    );

                    if ($bestGame) {
                        return sprintf(
                            'Monde %d - Étage %d', 
                            $bestGame->getReachedWorld(), 
                            $bestGame->getReachedStage()
                        );
                    }
                    
                    return 'Aucune partie';
                }),

        ];
    }
}