<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class CategoryType extends AbstractType
{
    private $name;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
    }
}