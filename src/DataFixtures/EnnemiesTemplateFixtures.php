<?php

namespace App\DataFixtures;

use App\Entity\EnnemiesTemplate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EnnemiesTemplateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Ton tableau avec les monstres et boss
        $ennemis = [
            // ==========================================
            // MONDE 1 : Saga Saiyan
            // ==========================================
            // Peu d'HP, Bonne attaque
            ['name' => 'Saibaman', 'hp' => 40, 'attack' => 15, 'xp' => 20, 'image' => 'saibaman.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 1],
            // Beaucoup d'HP, Faible attaque
            ['name' => 'Dinosaure Enragé', 'hp' => 100, 'attack' => 6, 'xp' => 20, 'image' => 'dinosaure.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 1],
            // Semi-Boss
            ['name' => 'Raditz', 'hp' => 250, 'attack' => 30, 'xp' => 100, 'image' => 'raditz.png', 'isBoss' => false, 'isSemiBoss' => true, 'world' => 1],
            // Boss
            ['name' => 'Nappa', 'hp' => 600, 'attack' => 45, 'xp' => 250, 'image' => 'nappa.png', 'isBoss' => true, 'isSemiBoss' => false, 'world' => 1],

            // ==========================================
            // MONDE 2 : L'Armée de Freezer (Namek)
            // ==========================================
            ['name' => 'Soldat d\'Élite', 'hp' => 70, 'attack' => 28, 'xp' => 35, 'image' => 'soldat_elite.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 2],
            ['name' => 'Appule', 'hp' => 180, 'attack' => 12, 'xp' => 35, 'image' => 'appule.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 2],
            ['name' => 'Zarbon', 'hp' => 400, 'attack' => 50, 'xp' => 150, 'image' => 'zarbon.png', 'isBoss' => false, 'isSemiBoss' => true, 'world' => 2],
            ['name' => 'Ginyu', 'hp' => 900, 'attack' => 70, 'xp' => 350, 'image' => 'ginyu.png', 'isBoss' => true, 'isSemiBoss' => false, 'world' => 2],

            // ==========================================
            // MONDE 3 : L'Éveil de Freezer
            // ==========================================
            ['name' => 'Assassin de l\'Espace', 'hp' => 110, 'attack' => 45, 'xp' => 50, 'image' => 'assassin_espace.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 3],
            ['name' => 'Garde Lourd', 'hp' => 280, 'attack' => 20, 'xp' => 50, 'image' => 'garde_lourd.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 3],
            ['name' => 'Freezer (2ème Forme)', 'hp' => 750, 'attack' => 75, 'xp' => 250, 'image' => 'freezer_forme2.png', 'isBoss' => false, 'isSemiBoss' => true, 'world' => 3],
            ['name' => 'Freezer (Forme Finale)', 'hp' => 1400, 'attack' => 100, 'xp' => 550, 'image' => 'freezer_final.png', 'isBoss' => true, 'isSemiBoss' => false, 'world' => 3],

            // ==========================================
            // MONDE 4 : Saga Cyborgs
            // ==========================================
            ['name' => 'Drone Espion', 'hp' => 160, 'attack' => 65, 'xp' => 80, 'image' => 'drone.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 4],
            ['name' => 'Cyborg Défectueux', 'hp' => 420, 'attack' => 30, 'xp' => 80, 'image' => 'cyborg_base.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 4],
            ['name' => 'Cyborg 19', 'hp' => 1100, 'attack' => 95, 'xp' => 380, 'image' => 'cyborg_19.png', 'isBoss' => false, 'isSemiBoss' => true, 'world' => 4],
            ['name' => 'Cyborg 17 & 18', 'hp' => 2200, 'attack' => 135, 'xp' => 850, 'image' => 'cyborg_1718.png', 'isBoss' => true, 'isSemiBoss' => false, 'world' => 4],

            // ==========================================
            // MONDE 5 : Le Tournoi de Cell
            // ==========================================
            ['name' => 'Cell Jr.', 'hp' => 240, 'attack' => 90, 'xp' => 120, 'image' => 'cell_jr.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 5],
            ['name' => 'Mutant Biologique', 'hp' => 600, 'attack' => 45, 'xp' => 120, 'image' => 'mutant.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 5],
            ['name' => 'Cell (2ème Forme)', 'hp' => 1600, 'attack' => 125, 'xp' => 500, 'image' => 'cell_forme2.png', 'isBoss' => false, 'isSemiBoss' => true, 'world' => 5],
            ['name' => 'Cell Parfait', 'hp' => 3200, 'attack' => 180, 'xp' => 1200, 'image' => 'cell_parfait.png', 'isBoss' => true, 'isSemiBoss' => false, 'world' => 5],

            // ==========================================
            // MONDE 6 : Le Réveil de Majin
            // ==========================================
            ['name' => 'Pui Pui', 'hp' => 350, 'attack' => 120, 'xp' => 180, 'image' => 'puipui.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 6],
            ['name' => 'Yakon', 'hp' => 850, 'attack' => 65, 'xp' => 180, 'image' => 'yakon.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 6],
            ['name' => 'Dabra', 'hp' => 2400, 'attack' => 165, 'xp' => 750, 'image' => 'dabra.png', 'isBoss' => false, 'isSemiBoss' => true, 'world' => 6],
            ['name' => 'Majin Vegeta', 'hp' => 4800, 'attack' => 240, 'xp' => 1800, 'image' => 'majin_vegeta.png', 'isBoss' => true, 'isSemiBoss' => false, 'world' => 6],

            // ==========================================
            // MONDE 7 : La Menace Buu
            // ==========================================
            ['name' => 'Clone de Buu', 'hp' => 500, 'attack' => 160, 'xp' => 260, 'image' => 'buu_clone.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 7],
            ['name' => 'Golem de Kiri', 'hp' => 1200, 'attack' => 85, 'xp' => 260, 'image' => 'golem.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 7],
            ['name' => 'Super Buu', 'hp' => 3500, 'attack' => 220, 'xp' => 1100, 'image' => 'super_buu.png', 'isBoss' => false, 'isSemiBoss' => true, 'world' => 7],
            ['name' => 'Kid Buu', 'hp' => 7000, 'attack' => 320, 'xp' => 2800, 'image' => 'kid_buu.png', 'isBoss' => true, 'isSemiBoss' => false, 'world' => 7],

            // ==========================================
            // MONDE 8 : Battle of Gods
            // ==========================================
            ['name' => 'Combattant Divin', 'hp' => 700, 'attack' => 210, 'xp' => 380, 'image' => 'combattant_divin.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 8],
            ['name' => 'Gardien de l\'Arbre', 'hp' => 1700, 'attack' => 110, 'xp' => 380, 'image' => 'gardien.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 8],
            ['name' => 'Whis (Illusion)', 'hp' => 5000, 'attack' => 280, 'xp' => 1600, 'image' => 'whis.png', 'isBoss' => false, 'isSemiBoss' => true, 'world' => 8],
            ['name' => 'Beerus', 'hp' => 10000, 'attack' => 410, 'xp' => 4000, 'image' => 'beerus.png', 'isBoss' => true, 'isSemiBoss' => false, 'world' => 8],

            // ==========================================
            // MONDE 9 : L'Avenir Trunks / Black
            // ==========================================
            ['name' => 'Zamasu (Hologramme)', 'hp' => 950, 'attack' => 280, 'xp' => 550, 'image' => 'zamasu_holo.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 9],
            ['name' => 'Soldat de la Résistance', 'hp' => 2400, 'attack' => 140, 'xp' => 550, 'image' => 'soldat_resistance.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 9],
            ['name' => 'Zamasu Fusionné', 'hp' => 7000, 'attack' => 360, 'xp' => 2400, 'image' => 'zamasu_fusion.png', 'isBoss' => false, 'isSemiBoss' => true, 'world' => 9],
            ['name' => 'Goku Black (Rosé)', 'hp' => 14000, 'attack' => 550, 'xp' => 6000, 'image' => 'goku_black.png', 'isBoss' => true, 'isSemiBoss' => false, 'world' => 9],

            // ==========================================
            // MONDE 10 : Le Tournoi du Pouvoir
            // ==========================================
            ['name' => 'Loup du Trio Danger', 'hp' => 1300, 'attack' => 370, 'xp' => 800, 'image' => 'trio_danger.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 10],
            ['name' => 'Cyborg de l\'Univers 3', 'hp' => 3300, 'attack' => 180, 'xp' => 800, 'image' => 'cyborg_u3.png', 'isBoss' => false, 'isSemiBoss' => false, 'world' => 10],
            ['name' => 'Toppo (Dieu de la Destruction)', 'hp' => 10000, 'attack' => 480, 'xp' => 3500, 'image' => 'toppo.png', 'isBoss' => false, 'isSemiBoss' => true, 'world' => 10],
            ['name' => 'Jiren', 'hp' => 22000, 'attack' => 750, 'xp' => 10000, 'image' => 'jiren.png', 'isBoss' => true, 'isSemiBoss' => false, 'world' => 10],
        ];

        foreach ($ennemis as $data) {
            $ennemi = new EnnemiesTemplate();
            $ennemi->setName($data['name']);
            $ennemi->setBaseHp($data['hp']);
            $ennemi->setBaseAttack($data['attack']);
            $ennemi->setXpReward($data['xp']);
            $ennemi->setImagePath($data['image']);
            $ennemi->setIsBoss($data['isBoss']);
            $ennemi->setIsSemiBoss($data['isSemiBoss']);
            $ennemi->setWorld($data['world']);

            $manager->persist($ennemi);
        
        }

        // On envoie tout dans la base de données
        $manager->flush();
    }
}