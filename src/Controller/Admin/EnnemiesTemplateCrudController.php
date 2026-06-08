<?php

namespace App\Controller\Admin;

use App\Entity\EnnemiesTemplate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;


class EnnemiesTemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EnnemiesTemplate::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom du personnage');
        yield IntegerField::new('baseHp', 'Points de Vie (HP)');

        yield IntegerField::new('baseAttack', 'Attaque de base');
        yield TextField::new('imagePath', 'Nom du fichier image (ex: goku.png)');
        yield IntegerField::new('xpReward', 'Points d\'expérience gagnés');
        yield BooleanField::new('isBoss', 'Est un boss ?');
        yield BooleanField::new('isSemiBoss', 'Est un semi-boss ?');
    }
    
}
