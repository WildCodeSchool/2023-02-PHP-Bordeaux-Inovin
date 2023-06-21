<?php

namespace App\Controller\Admin;

use App\Entity\User;
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

    public function configureFields(string $pageName): iterable
    {

        yield    IdField::new('id')->hideOnForm();

        yield    TextField::new('firstname');

        yield    TextField::new('lastname');

        yield    EmailField::new('email');

        yield       ChoiceField::new('roles')
                ->allowMultipleChoices()
                ->setChoices([
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_USER' => 'ROLE_USER',
                ]);

        yield    TextField::new('password');

        yield    DateField::new('birthday');

        yield    IntegerField::new('zipcode');

        yield    TextField::new('phone_number');

        yield    BooleanField::new('isVerified')->hideOnForm();

        yield    DateTimeField::new('createdAt')->hideOnForm();

        yield    DateTimeField::new('updatedAt')->hideOnForm();
    }
}
