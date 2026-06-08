<?php

namespace App\DataFixtures;

use App\Entity\HeroTemplate;
use App\Entity\Skill; 
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
class HeroTemplateFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $skillRepo = $manager->getRepository(Skill::class);

        $templates = [
            [
                'name' => 'goku', 'hp' => 200, 'ki' => 150, 'attack' => 30, 'image' => 'goku.png',
                'skills' => ['kamehameha', 'genkidama', 'kaioken', 'super_saiyan']
            ],
            [
                'name' => 'piccolo', 'hp' => 180, 'ki' => 200, 'attack' => 25, 'image' => 'piccolo.png',
                'skills' => ['makankosappo', 'masenko', 'soin']
            ],
            [
                'name' => 'yamcha', 'hp' => 100, 'ki' => 80, 'attack' => 15, 'image' => 'yamcha.png',
                'skills' => ['roga_fufu_ken', 'sokidan']
            ],
        ];

        foreach ($templates as $data) {
            $heroTemplate = new HeroTemplate();
            $heroTemplate->setName($data['name']);
            $heroTemplate->setBaseHp($data['hp']);
            $heroTemplate->setBaseKi($data['ki']);
            $heroTemplate->setAttack($data['attack']);
            $heroTemplate->setImagePath($data['image']);

            foreach ($data['skills'] as $skillId) {
                $skill = $skillRepo->findOneBy(['identifiant' => $skillId]);
                if ($skill) {
                    $heroTemplate->addSkill($skill);
                }
            }

            $manager->persist($heroTemplate);
        }

        $manager->flush();
    }

    // charger les skills en premier pour pouvoir les associer aux héros
    public function getDependencies(): array
    {
        return [
            SkillFixtures::class,
        ];
    }
}