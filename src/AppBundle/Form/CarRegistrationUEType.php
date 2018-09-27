<?php
/**
 * Created by PhpStorm.
 * User: b0ndurant
 * Date: 27/09/18
 * Time: 23:01
 */

namespace AppBundle\Form;


use AppBundle\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarRegistrationUEType extends AbstractType
{
    /**
     * {@inheritdoc}
     *
     * @param FormBuilderInterface $builder The formBuilderInterface form
     * @param array                $options The attribute array
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', ChoiceType::class,
                [
                    'choices' =>
                        [
                            "Mr" => "Mr",
                            "Mme" => "Mme",
                            "Mlle" => "Mlle"
                        ]
                ])
            ->add('lastName', TextType::class)
            ->add('firstName', TextType::class)
            ->add('phoneNumber', TextType::class)
            ->add('email', TextType::class)
            ->add('licenseDriver', FileType::class,
                [
                    'required' => true,
                    'data_class' => null,
                    'multiple' => true
                ])
            ->add('controlT', FileType::class,
                [
                    'required' => true,
                ])
            ->add('immatRequest', FileType::class,
                [
                    'required' => true,
                ])
            ->add('mandat', FileType::class,
                [
                    'required' => true,
                ])
            ->add('domJustify', FileType::class,
                [
                    'required' => true,
                    'data_class' => null,
                    'multiple' => true
                ])
            ->add('insuranceCertificate', FileType::class,
                [
                    'required' => true,
                ])
            ->add('transferOrSales', FileType::class,
                [
                    'required' => true,
                ])
            ->add('ueConformity', FileType::class,
                [
                    'required' => true,
                    'data_class' => null,
                    'multiple' => true
                ])
            ->add('quitus', FileType::class,
                [
                    'required' => true,
                ])
            ->add('carRegistration', FileType::class,
                [
                    'required' => true,
                    'data_class' => null,
                    'multiple' => true
                ]
            );
    }

    /**
     * {@inheritdoc}
     *
     * @param OptionsResolver $resolver The optionResolver class
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Document::class
            ]
        );
    }
}