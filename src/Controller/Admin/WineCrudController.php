<?php

namespace App\Controller\Admin;

use App\Entity\Wine;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WineCrudController extends AbstractCrudController
{
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'Ajouter un vin')
            ->setPageTitle('index', 'Liste des vins')
            ->setEntityLabelInSingular('un Vin');
    }
    public static function getEntityFqcn(): string
    {
        return Wine::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('producer', 'Producteur'),
            TextField::new('production_year', 'Année de production'),
            AssociationField::new('color', 'couleur'),
            AssociationField::new('cepage', 'Cépage'),
            DateTimeField::new('updated_at')->hideOnForm(),
            DateTimeField::new('created_at')->hideOnForm(),
        ];
    }
}
