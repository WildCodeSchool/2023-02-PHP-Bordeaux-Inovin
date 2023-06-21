<?php

namespace App\Controller\Admin;

use App\Entity\Region;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RegionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Region::class;
    }


    public function configureFields(string $pageName): iterable
    {
         return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name_region'),
            DateTimeField::new('updated_at')->hideOnForm(),
            DateTimeField::new('created_at')->hideOnForm(),
         ];
    }
}
