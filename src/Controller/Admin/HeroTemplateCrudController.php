<?php

namespace App\Controller\Admin;

use App\Entity\HeroTemplate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class HeroTemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HeroTemplate::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom du personnage');
        yield IntegerField::new('baseHp', 'Points de Vie (HP)');
        yield IntegerField::new('baseKi', 'Points de Ki (MP)');
        yield IntegerField::new('attack', 'Attaque de base');
        yield TextField::new('imagePath', 'Nom du fichier image (ex: goku.png)');
        

        yield AssociationField::new('skills', 'Catalogue des compétences disponibles')
            ->setFormTypeOptions([
                'by_reference' => false, 
                'multiple' => true,      
                'expanded' => true,     
            ]);
    }
}