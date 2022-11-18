<?php

namespace App\Controller\Admin;

use App\Entity\NewsSource;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NewsSourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NewsSource::class;
    }

    /*
     public function configureFields(string $pageName): iterable
        {
            return [
                IdField::new('id'),
                TextField::new('title'),
                TextEditorField::new('description'),
            ];
        }
    */
}
