<?php

namespace App\Controller\Admin;

use App\Entity\Cupcake;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CupcakeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cupcake::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            TextEditorField::new('description'),
            ImageField::new('image')->setUploadDir('public/uploads/images'),
            AssociationField::new('colors','Colors') ->setFormTypeOptions([
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'name',
            ]),
        ];
    }
    
}
