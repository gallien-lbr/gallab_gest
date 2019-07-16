<?php

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceMultiLinesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lines', CollectionType::class,[
                        'entry_type' => InvoiceLineType::class,
                        'entry_options' => [
                            'attr' => ['class' => 'test']
                         ],
                        'allow_add' => true,
                        'allow_delete' => true,
                        // set to false in order to disable it
                        'label'=> false,
                        /* for some mysterious reasons, if `by_reference` is not set to FALSE
                           invoice_id remain NULL in invoice_line table
                           some people seem to face same issue as described here:
                           @link: https://openclassrooms.com/forum/sujet/symfony2-la-foreign-key-reste-null
                        */
                        'by_reference' => false,
        ])
            ->add('submit' ,SubmitType::class,[
                'label' => 'Save',
                'attr' => ['class' => 'save btn-primary btn-lg btn-block' ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
            'block_prefix' => 'multiEdit',
        ]);
    }
}
