<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 11/01/2018
 * Time: 10:20
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }
    public function getParent()
    {
        return ProjectType::class;
    }

}