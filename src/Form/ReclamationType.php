<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Security;

class ReclamationType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData'])
            ->add('Description')
            ->add('ReferencePd');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }

    public function onPreSetData(FormEvent $event): void
    {
        $reclamation = $event->getData();
        $form = $event->getForm();

        // Check if the Reclamation object is not null and CodeClt is not set
        if ($reclamation && !$reclamation->getCodeClt()) {
            // Get the current authenticated user
            $user = $this->security->getUser();
            // Set the CodeClt to the current user's ID
            $reclamation->setCodeClt($user);
            // Rebuild the form with the updated data
            $form->add('CodeClt', null, ['disabled' => true]); // Optional: Disable editing of CodeClt field
        }
    }
}
