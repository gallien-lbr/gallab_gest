<?php


namespace App\Form;


use App\Entity\Customer;
use App\Entity\Invoice;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_start',DateType::class,[
               //'mapped' => false,
                'help' => '(paid date)',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'format' => 'dd-mm-yyyy',
        ])
            ->add('date_end',DateType::class,[
              //  'mapped' => false,
                'help' => '(paid date)',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'format' => 'dd-mm-yyyy',
            ])
            ->add('customer',EntityType::class, [
                    'class' => Customer::class,
                    'choice_label' => 'name',
                    'required' => false,
                ])
            ->add('filter', SubmitType::class, [
                'label' => 'Filter',
                'attr' => ['class' => 'save btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        /*$resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);*/
    }


}