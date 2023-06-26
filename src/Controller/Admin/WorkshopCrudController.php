<?php

namespace App\Controller\Admin;

use App\Entity\Workshop;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'Ajouter un atelier')
            ->setPageTitle('index', 'Liste des ateliers');
    }

    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->hideOnForm();

        yield TextField::new('name_workshop', 'Nom de l\'atelier');

        yield IntegerField::new('code_workshop', 'Code de l\'atelier');

        yield TextField::new('place_workshop', 'Lieu de l\'atelier');

        yield DateTimeField::new('date_workshop', 'Date de l\'atelier');

        yield DateTimeField::new('created_at', 'Créer')->hideOnForm();

        yield DateTimeField::new('updated_at', 'Modifier')->hideOnForm();

        yield AssociationField::new('wines', 'Vins')
            ->setFormTypeOptions([
                'multiple' => true,
                'by_reference' => false,])
            ->setHelp('Choisissez 4 vins');
    }
}
