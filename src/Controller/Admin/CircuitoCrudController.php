<?php

namespace App\Controller\Admin;

use App\Entity\Circuito;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CircuitoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Circuito::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('denominacion'),

            AssociationField::new('distrito')
            ->setLabel('Distrito')
            // Opcional: Si tienes muchísimas zonas, usa 'autocomplete' para un campo de búsqueda con Ajax
            // ->autocomplete(),
        ];
    }

}
