<?php

namespace App\Form;

use App\Entity\InvoiceLine;
use App\Entity\LineUnit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('detail',TextareaType::class,[
                'label' => 'Line description'
            ])
            ->add('qty',IntegerType::class,[
                'label' => 'Quantity',
            ])
            ->add('unit', EntityType::class,[
                'choice_label' => 'name',
                'class' => LineUnit::class,
            ])
            ->add('price',MoneyType::class,
                [
                    'label' => 'Price per unit (required)',
                ]
            )
            ->add('totalPrice',MoneyType::class,[
                'label' => 'Line price',
                //'mapped' => false,
                'disabled' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InvoiceLine::class,
        ]);
    }
}
