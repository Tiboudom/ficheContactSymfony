<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FicheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, ['label' => 'Nom'])
            ->add('firstName', TextType::class, ['label' => 'Prenom'])
            ->add('mail', EmailType::class, ['label' => 'eMail'])
            ->add('contact', EntityType::class, [
                'class' => Contact::class,
                'choice_label' => 'contactJob',

            ])
            ->add('object', TextType::class, ['label' => 'Objet'])
            ->add('message', TextType::class, ['label' => 'Message'])
            ->add('save', SubmitType::class, ['label' => 'Envoyer'])
        ;
    }
}