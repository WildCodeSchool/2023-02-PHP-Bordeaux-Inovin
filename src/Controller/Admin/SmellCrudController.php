<?php

namespace App\Controller\Admin;

use App\Entity\Smell;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SmellCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Smell::class;
    }


    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->hideOnForm();

        yield TextField::new('name_smell');

        yield DateTimeField::new('updated_at')->hideOnForm();

        yield DateTimeField::new('created_at')->hideOnForm();
    }
}
