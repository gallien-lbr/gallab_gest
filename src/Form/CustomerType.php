<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[

                'attr' => ['placeholder' => 'HelloWorld Ltd.' ],
                'label' => 'Nom entreprise (*)',
            ])
            ->add('contactName', TextType::class,[
                'label' => 'Interlocuteur (*)'
            ])

            ->add('country', EntityType::class,[
                'class' => Country::class,
                'choice_label' => 'name',
                'placeholder' => 'France',
                'empty_data' => 'FR',
                'required' => false,
                //'' =>  $this->em->getReference(Country::class,'FR'),
                'label' => 'Pays',
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Sauvegarder',
                'attr' => ['class' => 'save btn-primary'],
            ])

            ->add('phone', TelType::class,
                [
                    'attr' => ['placeholder' => '+44 123456789'],
                    'required' => false,
                    'label' => 'Tél.'
                ]
            )
            ->add('email', EmailType::class,
                [
                    'attr' => ['placeholder'=>'contact@helloworld-ltd.net'],
                    'required' => false,
                ])
            ->add('website',UrlType::class,[
               'attr' =>  ['placeholder' => 'https://example.com'],
               'required' => false,
                'default_protocol' => 'https',
                'label'=>'Site internet',
            ])
            ->add('address1',TextType::class,[
                'label' => 'Adresse principale',
            ])
            ->add('address2',TextType::class,[
                'label' => 'Adresse (complément)'
            ])
            ->add('postalCode', TextType::class,[
                'label'=>'Code Postal',
            ])
            ->add('city',TextType::class,[
                'label' => 'Ville',
            ])

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
