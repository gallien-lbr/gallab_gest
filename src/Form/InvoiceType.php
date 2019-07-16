<?php

namespace App\Form;

use App\Entity\Invoice;
use App\Entity\Customer;
use App\Entity\InvoiceCategory;
use App\Entity\PaymentMethod;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('reference', TextType::class,
                                [
                                    'label' => 'Réf (requis)',
                                    'help' => 'Référence unique de facture  (ex: FACT-2019-12)'
                                ]
            )
            ->add('descr', TextType::class,[
                'label' => 'Description (requis)',
                'help' => 'Description courte (eg: 3 jours de Développement PHP)'
            ])



            ->add('save', SubmitType::class, [
                'label' => 'Sauvegarder',
                'attr' => ['class' => 'save btn-primary btn-lg btn-block' ],
            ])

            ->add('sent_at', DateType::class,
                                    [
                                        'label' => 'Date émission',
                                        'widget' => 'single_text',
                                        'html5' => false,
                                        'attr' => ['class' => 'js-datepicker'],
                                        'format' => 'dd-MM-yyyy',
                                        'required' => false,
                                    ]
            )
            ->add('paid_at', DateType::class,
                                    [
                                        'label' => 'Date encaissement',
                                        'required' => false,
                                        'widget' => 'single_text',
                                        'html5' => false,
                                        'attr' => ['class' => 'js-datepicker'],
                                        'format' => 'dd-MM-yyyy',

                                    ]
            )

            ->add('paymentMaxDuration',IntegerType::class,[
                     'label' => 'Nb jours max paiement :',
                    'required' => true,
            ])

            ->add('customer',EntityType::class,
                                        [
                                            'label' => 'Client',
                                            'class' => Customer::class,
                                            'choice_label' => 'name',
                                            'required' => false,
                                            'placeholder' => 'Aucun client assigné',
                                        ]
            )
            ->add('paymentMethod',EntityType::class,
                [
                    'label' => 'Méthode de paiement',
                    'class' => PaymentMethod::class,
                    'choice_label' => 'name',
                    'required' => false,
                    'placeholder' => 'Aucune méthode assignée',
                ]
             )
            ->add('category', EntityType::class,
                [
                    'label' => 'Catégorie',
                    'class' => InvoiceCategory::class,
                    'choice_label' => 'name',
                    'required' => false,
                    'placeholder' => 'Aucune catégorie assignée',
                ]
            )

            ->add('generatePdf', CheckboxType::class,[
                'label' => 'Utiliser l\'application pour générer le PDF de la facture',
                'help' => 'Choix optionnel',
                'required' => false,
            ])


        ;

        /**
         * @var Invoice $entity
         */
        $entity = $builder->getData();
        $duration = $entity!==null ? $entity->getPaymentMaxDuration() : '30';

        $builder->add('notes', TextareaType::class, [
            'attr' => [

            ],
            'label' => 'Notes pieds facture (option)',
            'data' => '
                               <strong>Echéance règlement :</strong><br />
                                Délai de paiement de '. $duration .' jours à compter de la réception de la facture.</i><br />
                                Payable comptant à réception de la facture.<br />
                                Nos conditions de vente ne prévoient pas d’escompte pour paiement anticipé.
                           ',
        ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
