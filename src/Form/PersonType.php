<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add(
                'phones',
                CollectionType::class,
                [
                    // each entry in the array will be an "email" field
                    'entry_type' => PhoneNumberType::class,
                    'allow_add' => true,
                    // these options are passed to each "email" type
                    'entry_options' => [],
                ]
            )
            ->add(
                'addresses',
                CollectionType::class,
                [
                    // each entry in the array will be an "email" field
                    'entry_type' => AddressType::class,
                    'allow_add' => true,
                    // these options are passed to each "email" type
                    'entry_options' => [],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'csrf_protection' => false
//            'data_class' => PhoneType::class,
            ]
        );
    }
}
