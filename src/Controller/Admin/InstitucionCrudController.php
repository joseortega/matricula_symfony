<?php

namespace App\Controller\Admin;

use App\Entity\Institucion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InstitucionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Institucion::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('denominacion'),
            AssociationField::new('circuito')
            ->setLabel('Circuito'),
        ];
    }

}
