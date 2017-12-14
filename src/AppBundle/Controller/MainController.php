<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 14/12/2017
 * Time: 11:12
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function homepageAction()
    {
        return $this->render('main/homepage.html.twig');
    }

}