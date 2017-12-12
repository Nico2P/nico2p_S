<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{

    /**
     * @Route("/home")
     */
    public function homeAction()
    {
        return new Response("Première réponse");
    }











    /**
     *
     *                  TEST
     *
     */


    /**
     * @Route("/test/{slug}")
     */
    public function showParamAction($slug)
    {

        $notes = [
            'Pouet info',
            'test bla bla',
            'pouet pouet pouet pouet'
        ];

        return $this->render('home/show.html.twig', [
            'slug'=> $slug,
            'notes'=> $notes
        ]);
    }


    /**
     *
     *                  TEST
     *
     */

}