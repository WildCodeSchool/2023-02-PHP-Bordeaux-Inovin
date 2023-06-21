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
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name_smell'),
            DateTimeField::new('updated_at')->hideOnForm(),
            DateTimeField::new('created_at')->hideOnForm(),
        ];
    }
}
