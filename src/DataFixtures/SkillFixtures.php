<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $skillsData = [
            // liste des compétences
            // php bin/console doctrine:fixtures:load
            // utiliser cette commande apres chaque modification MAIS UNIQUEMENT EN PHASE DE DEV
            ['name' => 'Kamehameha', 'identifier' => 'kamehameha', 'ki_cost' => 15, 'damage' => 35, 'type' => 'damage', 'niveau_requis' => 1],
            ['name' => 'Genkidama', 'identifier' => 'genkidama', 'ki_cost' => 50, 'damage' => 150, 'type' => 'damage', 'niveau_requis' => 5],
            ['name' => 'Makankosappo', 'identifier' => 'makankosappo', 'ki_cost' => 20, 'damage' => 55, 'type' => 'damage', 'niveau_requis' => 3],
            ['name' => 'Masenko', 'identifier' => 'masenko', 'ki_cost' => 10, 'damage' => 25, 'type' => 'damage', 'niveau_requis' => 1],
            ['name' => 'Sokidan', 'identifier' => 'sokidan', 'ki_cost' => 25, 'damage' => 50, 'type' => 'damage', 'niveau_requis' => 2],
            ['name' => 'Roga Fufu Ken', 'identifier' => 'roga_fufu_ken', 'ki_cost' => 12, 'damage' => 30, 'type' => 'damage', 'niveau_requis' => 1],
            ['name' => 'Soin', 'identifier' => 'soin', 'ki_cost' => 12, 'damage' => 50, 'type' => 'heal', 'niveau_requis' => 1],
            ['name' => 'Kaioken', 'identifier' => 'kaioken', 'ki_cost' => 30, 'damage' => 15, 'type' => 'buff', 'niveau_requis' => 1, 'duree' => 5],
            ['name' => 'Super Saiyan', 'identifier' => 'super_saiyan', 'ki_cost' => 60, 'damage' => 40, 'type' => 'buff', 'niveau_requis' => 1, 'duree' => 10]

        ];

        foreach ($skillsData as $data) {
            $skill = new Skill();
            $skill->setName($data['name']);
            $skill->setIdentifiant($data['identifier']);
            $skill->setKiCost($data['ki_cost']);
            $skill->setDamage($data['damage']);
            $skill->setType($data['type']);
            $skill->setNiveauRequis($data['niveau_requis']);
            $skill->setDuree($data['duree']);

            $manager->persist($skill);
        }

        $manager->flush();
    }
}