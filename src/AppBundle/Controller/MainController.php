<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 14/12/2017
 * Time: 11:12
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{

    public function homepageAction()
    {
        return $this->render('main/homepage.html.twig');
    }

    /**
     * @Route("/projects")
     */
    public function projectAction()
    {
        return $this->render('main/projects.html.twig');
    }

    /**
     * @Route("/cv")
     */
    public function cvAction()
    {
        return $this->render('main/curriculum.html.twig');
    }

    /**
     * @Route("/contact")
     */
    public function contactAction()
    {
        return $this->render('main/contact.html.twig');
    }


}