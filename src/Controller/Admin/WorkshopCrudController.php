<?php

namespace App\Controller\Admin;

use App\Entity\Workshop;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WorkshopCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Workshop::class;
    }


    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->hideOnForm();

        yield TextField::new('name_workshop');

        yield IntegerField::new('code_workshop');

        yield TextField::new('place_workshop');

        yield DateTimeField::new('created_at')->hideOnForm();

        yield DateTimeField::new('updated_at')->hideOnForm();

        yield AssociationField::new('wines')
            ->setFormTypeOptions([
                'multiple' => true,
                'by_reference' => false,])
            ->setHelp('Choisissez 4 vins');
    }
}
