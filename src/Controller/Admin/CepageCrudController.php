<?php

namespace App\Controller\Admin;

use App\Entity\Cepage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'Ajouter un cépage')
            ->setPageTitle('index', 'Liste des cépages');
    }

    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->hideOnForm();

        yield TextField::new('name_cepage', 'Cépage');

        yield DateTimeField::new('updated_at', 'Modifier')->hideOnForm();

        yield DateTimeField::new('created_at', 'Créer')->hideOnForm();
    }
}
