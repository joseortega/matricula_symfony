<?php

namespace App\Controller\Admin;

use App\Entity\Distrito;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DistritoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Distrito::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('denominacion'),

            // Campo para la relación ManyToOne con Zona
            AssociationField::new('zona') // 'zona' es el nombre de la propiedad en la entidad Distrito
            ->setLabel('Zona a la que pertenece') // Etiqueta que quieres que muestre
            // Opcional: Si tienes muchísimas zonas, usa 'autocomplete' para un campo de búsqueda con Ajax
            // ->autocomplete(),
        ];
    }

}
