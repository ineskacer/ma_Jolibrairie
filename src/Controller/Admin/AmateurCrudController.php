<?php

namespace App\Controller\Admin;

use App\Entity\Amateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;

class AmateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Amateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // Id shouldn't be modified
            IdField::new('id')->hideOnForm(),
            // Completed will be rendered as a toggle only in edit
            // Title will be rendered so as to include a link, and be striked whenever completed
            TextField::new('nom'),
            TextField::new('description'),
            AssociationField::new('librairie')
                    ->onlyOnDetail()
                    ->setTemplatePath('admin/fields/amateur_librairies.html.twig')
  
            ];
    }
    
    public function configureActions(Actions $actions): Actions
    {
        // For whatever reason show isn't in the menu, bu default
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        // Customize the rendering of the row to grey-out the completed Todos
        return $crud
            
        ;
    }

}
