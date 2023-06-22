<?php

namespace App\Controller\Admin;

use App\Entity\Gout;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class GoutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gout::class;
    }


    public function configureFields(string $pageName): iterable
    {

        yield AssociationField::new('user', 'Utilisateur');

        yield CollectionField::new('color', 'Couleur');

        yield CollectionField::new('region', 'Régions');

        yield CollectionField::new('arome', 'Arômes');
    }
}
