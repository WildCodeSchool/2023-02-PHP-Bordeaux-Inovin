<?php

namespace App\Controller\Admin;

use App\Entity\Color;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ColorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Color::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'Ajouter une couleur')
            ->setPageTitle('index', 'Liste des Couleurs')
            ->setEntityLabelInSingular('une couleur');
    }

    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->hideOnForm();

        yield TextField::new('name_color', 'Couleur');

        yield DateTimeField::new('created_at', 'Créer')->hideOnForm();

        yield DateTimeField::new('updated_at', 'Modifier')->hideOnForm();
    }
}
