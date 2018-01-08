<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;


class TestController extends Controller
{
    /**
     * @Route("/test")
     */
    public function testAction()
    {
        return new Response("Première réponse");
    }











    /**
     *
     *                  TEST
     *
     */

    /**
     * @Route("/test/form")
     * Test form
     */
    public function addAction()
    {
        $post = new Post();
        $formBuilder = $this->get('form.factory')->createBuilder(formType::class);
        $formBuilder
            ->add('auteur', TextType::class)
            ->add('Message', TextareaType::class)
            ;

        $form = $formBuilder->getForm();


        return $this->render('test/form.html.twig', array(
            'form' => $form->createView(),
        ));


        //$em = $this->getDoctrine()->getManager();
        //$em->persist($post);
        //$em->flush();

        //return new Response("<html><body>post crée en bdd</body></html>");
    }





    /**
     * @Route("/test/new")
     * Test ajout bd
     */
    public function newAction()
    {
        $post = new Post();
        $post->setDate(new \DateTime('now'));
        $post->setAuthor('Pouetotor'.rand(1,100));
        $post->setContent('Pouet contenu de test pouet'.rand(1,100));

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return new Response("<html><body>post crée en bdd</body></html>");
    }


    /**
     * @Route("/test/list" , name="test_list")
     * Test listing
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listMessages = $em->getRepository('AppBundle:Post')
            ->findAll();

        return $this->render('test/list.html.twig', [
            'listMessages' => $listMessages
        ]);
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

        return $this->render('test/show.html.twig', [
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