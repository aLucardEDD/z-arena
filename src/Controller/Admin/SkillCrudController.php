<?php

namespace App\Controller\Admin;

use App\Entity\Skill;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class SkillCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Skill::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom de la compétence');
        yield TextField::new('identifiant', 'Identifiant de la compétence');
        yield IntegerField::new('ki_cost', 'Coût en Ki');
        yield ChoiceField::new('type', 'Type de compétence')
            ->setChoices([
                'Dégâts (Attaque)' => 'damage',
                'Soin (Régénération)' => 'heal',
                'Buffs' => 'buff'
            ])
            ->renderExpanded(false) // false = menu déroulant, true = boutons radio
            ->renderAsBadges();     
        yield IntegerField::new('niveau_requis', 'Niveau requis');
        yield IntegerField::new('damage', 'Dommages infligés ou de buff ou de soin');
        yield IntegerField::new('duree', 'Durée du buff (en tours)');

    }
}
