<?php

namespace App\Controller\Admin;

use App\Entity\ItemTemplate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class ItemTemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ItemTemplate::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom de l\'item');
        yield ChoiceField::new('type', 'Type de compétence')
            ->setChoices([
                'Soins PV' => 'heal',
                'Régénération KI' => 'ki_restore',
                'Soin + Régénération' => 'heal_ki_restore',
                'Buffs PV' => 'buff_pv',
                'Buffs KI' => 'buff_ki',
                'Buffs Attaque' => 'buff_attack'
            ])
            ->renderExpanded(false) // false = menu déroulant, true = boutons radio
            ->renderAsBadges();     // (Optionnel) Ajoute un joli design de badge dans la liste
        yield IntegerField::new('value', 'Valeur de l\'item (soins, régénération ou buff)');   
        yield TextField::new('imagePath', 'Nom du fichier image (ex: potion.png)');    
        yield TextField::new('description', 'Description de l\'item'); 
        yield IntegerField::new('dropRate', 'Taux de drop de l\'item (%)');
    }
}
