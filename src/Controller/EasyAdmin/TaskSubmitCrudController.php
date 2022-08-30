<?php

namespace App\Controller\EasyAdmin;

use App\Entity\TaskSubmit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class TaskSubmitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TaskSubmit::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('id');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextareaField::new('fileContent');
        yield NumberField::new('score');
        yield TextAreaField::new('evaluatedBy');
        yield DateTimeField::new('uploadDate');
        yield AssociationField::new('task');
        yield AssociationField::new('user');
        yield AssociationField::new('submitType');
        yield BooleanField::new('evaluated');
    }
}
