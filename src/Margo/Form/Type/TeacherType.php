<?php

namespace Margo\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class TeacherType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => ' ',
                'constraints' => new Assert\NotBlank(),
                'attr' => array(
                    'placeholder' => 'Nom',
                )
            ))
            ->add('firstName', 'text', array(
                'label' => ' ',
                'constraints' => new Assert\NotBlank(),
                'attr' => array(
                    'placeholder' => 'Prénom',
                )
            ))
            ->add('idSubject', 'text', array(
                'label' => ' ',
                'constraints' => new Assert\NotBlank(),
                'attr' => array(
                    'placeholder' => 'Cours',
                )
            ))
            ->add('Enregistrer', 'submit');
    }

    public function getName()
    {
        return 'teacher';
    }

}