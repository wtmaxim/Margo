<?php

namespace Margo\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SubjectType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idSubject', 'text', array(
                'label' => ' ',
                'constraints' => new Assert\NotBlank(),
                'attr' => array(
                    'placeholder' => '1',
                )
            ))
            ->add('nameSubject', 'text', array(
                'label' => ' ',
                'constraints' => new Assert\NotBlank(),
                'attr' => array(
                    'placeholder' => 'SLAM4',
                )
            ))
            ->add('timeVolume', 'text', array(
                'label' => ' ',
                'constraints' => new Assert\NotBlank(),
                'attr' => array(
                    'placeholder' => '1',
                )
            ))
            ->add('coefficient', 'text', array(
                'label' => ' ',
                'constraints' => new Assert\NotBlank(),
                'attr' => array(
                    'placeholder' => '1',
                )
            ))
            ->add('Enregistrer', 'submit');
    }

    public function getName()
    {
        return 'subject';
    }

}