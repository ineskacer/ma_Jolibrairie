<?php

namespace App\Controller\Admin;

use App\Entity\Librairie;
use App\Entity\Livre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;



class LibrairieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Librairie::class;
    }

    public function configureFields(string $pageName): iterable
    {
          return [
              IdField::new('id')->hideOnForm(),
              TextField::new('description'),
              AssociationField::new('livres')
                  ->onlyOnDetail()
                  ->setTemplatePath('admin/fields/librairie_livres.html.twig')

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
