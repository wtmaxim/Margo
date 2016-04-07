<?php

namespace Margo\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class StudentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'constraints' => new Assert\NotBlank()
            ))
            ->add('firstName', 'text', array(
                'constraints' => new Assert\NotBlank()
            ))
            ->add('idCategory', 'text', array(
                'constraints' => new Assert\NotBlank()
            ))
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'etudiant';
    }

}