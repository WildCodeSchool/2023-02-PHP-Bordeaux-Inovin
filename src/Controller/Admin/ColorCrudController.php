<?php

namespace App\Controller\Admin;

use App\Entity\Color;
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


    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->hideOnForm();

        yield TextField::new('name_color');

        yield DateTimeField::new('updated_at')->hideOnForm();

        yield DateTimeField::new('created_at')->hideOnForm();
    }
}
