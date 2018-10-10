<?php
/**
 * Created by PhpStorm.
 * User: b0ndurant
 * Date: 27/09/18
 * Time: 23:09
 */

namespace AppBundle\Form;


use AppBundle\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdressChangeType extends AbstractType
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
            ->add('lastName', TextType::class,
                array('attr' => array('placeholder' => 'Votre nom'),
                    'constraints' => array(
                        new NotBlank(
                            array
                            ("message" => "Veuillez remplir votre nom")
                        ),
                    )
                ))
            ->add('firstName', TextType::class,
                array('attr' => array('placeholder' => 'Votre prénom'),
                    'constraints' => array(
                        new NotBlank(
                            array
                            ("message" => "Veuillez remplir votre prénom")
                        ),
                    )
                ))
            ->add('phoneNumber', TextType::class,
                array('attr' => array('placeholder' => 'Votre numéro de téléphone')))
            ->add(
                'email', EmailType::class,
                array('attr' => array('placeholder' => 'Votre adresse Email'),
                    'constraints' => array(
                        new NotBlank(array("message" => "Veuillez mettre un email valide")),
                        new Email(array("message" => "Votre email ne semble pas être valide")),
                    )
                ))            ->add('idCard', FileType::class,
                [
                    'required' => true,
                    'data_class' => null,
                    'multiple' => true
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