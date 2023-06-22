<?php

namespace App\Controller\Admin;

use App\Entity\Smell;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'Ajouter un arôme')
            ->setPageTitle('index', 'Liste des arômes');
    }

    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->hideOnForm();

        yield TextField::new('name_smell', 'Nom de l\'arôme');

        yield DateTimeField::new('created_at', 'Créer')->hideOnForm();

        yield DateTimeField::new('updated_at', 'Modifier')->hideOnForm();
    }
}
