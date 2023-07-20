<?php

namespace App\Controller\Admin;

use App\Entity\Arome;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AromeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Arome::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'Ajouter un arôme')
            ->setPageTitle('index', 'Liste des arômes')
            ->setEntityLabelInSingular('un arôme');
    }

    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->hideOnForm();

        yield TextField::new('name_arome', 'Nom de l\'arôme');

        yield DateTimeField::new('created_at', 'Créer')->hideOnForm();

        yield DateTimeField::new('updated_at', 'Modifier')->hideOnForm();
    }
}
