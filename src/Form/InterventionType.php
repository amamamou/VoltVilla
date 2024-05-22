<?php

namespace App\Form;

use App\Entity\Intervention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class InterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateInterv')
            ->add('Status') // Add the 'status' field here
            ->add('CodeClt')
            ->add('ReferencePd')
            ->add('CodeTech')
            ->add('reclamation', EntityType::class, [
                'class' => 'App\Entity\Reclamation',
                'choice_label' => 'id',
                // You can customize other options as needed
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}
