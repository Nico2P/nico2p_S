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

        $funFact = "pouet test essai *markdown bundle* par knplabs";

        $funFact = $this->get('markdown.parser')
            ->transform($funFact);

        $notes = [
            'Pouet info',
            'test bla bla',
            'pouet pouet pouet pouet'
        ];

        return $this->render('home/show.html.twig', [
            'slug'=> $slug,
            'notes'=> $notes,
            'funFact' => $funFact,
        ]);
    }


    /**
     *
     *                  TEST
     *
     */

}