<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des utilisateurs');
    }

    public function configureFields(string $pageName): iterable
    {

        yield    IdField::new('id')->hideOnForm();

        yield    TextField::new('firstname', 'Prénom');

        yield    TextField::new('lastname', 'Nom');

        yield    EmailField::new('email', 'Email');

        yield       ChoiceField::new('roles', 'Rôles')
                ->allowMultipleChoices()
                ->setChoices([
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_USER' => 'ROLE_USER',
                ]);

        yield    TextField::new('password', 'Mot de passe')->hideOnIndex();

        yield    DateField::new('birthday', 'Date de naissance');

        yield    IntegerField::new('zipcode', 'Code postal');

        yield    TextField::new('phone_number', 'Numéro de téléphone');

        yield    BooleanField::new('isVerified', 'Vérifier')->hideOnForm();

        yield    DateTimeField::new('createdAt', 'Créer')->hideOnForm();

        yield    DateTimeField::new('updatedAt', 'Modifier')->hideOnForm();
    }
}
