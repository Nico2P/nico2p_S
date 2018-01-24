<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 11/01/2018
 * Time: 10:22
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class, array('attr'=>array(
                'oninvalid'=>"setCustomValidity('Titre non valide')",
                'oninput'=>"setCustomValidity('')")) )

            ->add('date', DateType::class)

            ->add('url', TextType::class, array('attr'=>array(
                'oninvalid'=>"setCustomValidity('URL invalide')",
                'oninput'=>"setCustomValidity('')")) )

            ->add('description', TextareaType::class, array('attr'=>array(
                'oninvalid'=>"setCustomValidity('Ne dois pas être vide')",
                'oninput'=>"setCustomValidity('')")) )

            ->add('image', ImageType::class, array('attr'=>array(
                'oninvalid'=>"setCustomValidity('Aucune image selectionné')",
                'oninput'=>"setCustomValidity('')")) )

            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(Array(
            'data_class' => 'AppBundle\Entity\Project'
        ));
    }


}


