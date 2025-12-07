<?php

namespace App\Controller\Admin;

use App\Entity\GradoEscolar;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GradoEscolarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GradoEscolar::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('descripcion'),

            AssociationField::new('nivel')
            ->setLabel('Nivel')
            ->autocomplete(),
        ];
    }

}
