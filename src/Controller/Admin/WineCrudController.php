<?php

namespace App\Controller\Admin;

use App\Entity\Wine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Wine::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('producer'),
            TextField::new('production_year'),
            AssociationField::new('color'),
            AssociationField::new('cepage'),
            DateTimeField::new('updated_at')->hideOnForm(),
            DateTimeField::new('created_at')->hideOnForm(),
        ];
    }
}
