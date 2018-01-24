<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 11/01/2018
 * Time: 10:22
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('author', TextType::class , array('attr'=>array(
                'oninvalid'=>"setCustomValidity('Votre Nom')",
                'oninput'=>"setCustomValidity('')")) )

            ->add('email', EmailType::class, array('attr'=>array(
                'oninvalid'=>"setCustomValidity('Votre Email pour vous recontactez')",
                'oninput'=>"setCustomValidity('')")) )

            ->add('content', TextareaType::class, array('attr'=>array(
                'oninvalid'=>"setCustomValidity('Le contenu de votre message')",
                'oninput'=>"setCustomValidity('')")) )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(Array(
            'data_class' => 'AppBundle\Entity\Post'
        ));
    }


}