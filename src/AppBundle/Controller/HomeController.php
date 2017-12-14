<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Post;
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
     * @Route("/test/new")
     * Test ajout bd
     */
    public function newAction()
    {
        $post = new Post();
        $post->setDate(new \DateTime('now'));
        $post->setAuthor('Pouetotor');
        $post->setContent('Pouet contenu de test pouet'.rand(1,100));

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return new Response("<html><body>post crée</body>></html>");
    }


    /**
     * @Route("/test/{slug}")
     */
    public function showParamAction($slug)
    {

        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');

        $funFact = "pouet test essai *markdown bundle* par knplabs";

        $key = md5($funFact);

        if($cache->contains($key)){
            $funFact = $cache->fetch($key);
        } else {
            sleep(1);
            $funFact = $this->get('markdown.parser')
                ->transform($funFact);
            $cache->save($key, $funFact);
        }



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