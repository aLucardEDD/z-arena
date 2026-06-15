<?php

namespace App\DataFixtures;

use App\Entity\ItemTemplate; 
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
class ItemTemplateFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $items = [
            ['Capsule Vie S', 'heal', 10, 30, 'capsule_vie_s.png', 'Une petite capsule de soin.'],
            ['Capsule Ki S', 'ki_restore', 10, 30, 'capsule_ki_s.png', 'Une petite capsule d\'énergie.'],
            ['Capsule Vie M', 'heal', 25, 15, 'capsule_vie_m.png', 'Une capsule de soin moyenne.'],
            ['Capsule Ki M', 'ki_restore', 25, 15, 'capsule_ki_m.png', 'Une capsule d\'énergie moyenne.'],
            ['Capsule Totale L', 'heal_ki_restore', 50, 5, 'capsule_totale_l.png', 'Restaure PV et Ki.'],
            ['Senzu', 'heal_ki_restore', 100, 5, 'senzu.png', 'Le haricot magique miracle.'],

            ['Entraînement : Force S', 'buff_attack', 5, 26, 'buff_atk.png', 'Augmente de manière permanente votre attaque de base de 5 points.'],
            ['Entraînement : Endurance S', 'buff_pv', 10, 26, 'buff_hp.png', 'Augmente de manière permanente vos PV max de 10 points.'],
            ['Entraînement : Esprit S', 'buff_ki', 10, 26, 'buff_ki.png', 'Augmente de manière permanente votre Ki max de 10 points.'],

            ['Entraînement : Force M', 'buff_attack', 8, 5, 'buff_atk.png', 'Augmente de manière permanente votre attaque de base de 8 points.'],
            ['Entraînement : Endurance M', 'buff_pv', 15, 8, 'buff_hp.png', 'Augmente de manière permanente vos PV max de 15 points.'],
            ['Entraînement : Esprit M', 'buff_ki', 15, 10, 'buff_ki.png', 'Augmente de manière permanente votre Ki max de 15 points.'],
        ];

        foreach ($items as $data) {
            $item = new ItemTemplate();
            $item->setName($data[0]);
            $item->setType($data[1]);
            $item->setValue($data[2]);
            $item->setDropRate($data[3]);
            $item->setImagePath($data[4]);
            $item->setDescription($data[5]);
            
            $manager->persist($item);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SkillFixtures::class,
        ];
    }
}
            