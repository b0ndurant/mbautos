<?php
namespace AppBundle\Form;

use AppBundle\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
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
                ]
            )
            ->add('lastName', TextType::class)
            ->add('firstName', TextType::class)
            ->add('phoneNumber', TextType::class)
            ->add('email', TextType::class)
            ->add('carRegistration', FileType::class,
            [
                'required' => true,
                'data_class' => null,
                'multiple' => true
            ]
            )
        ;
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