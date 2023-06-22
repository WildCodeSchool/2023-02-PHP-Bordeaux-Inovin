<?php

namespace App\Controller\Admin;

use App\Entity\Cepage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CepageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cepage::class;
    }


    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->hideOnForm();

        yield TextField::new('name_cepage');

        yield DateTimeField::new('updated_at')->hideOnForm();

        yield DateTimeField::new('created_at')->hideOnForm();
    }
}
