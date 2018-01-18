<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 14/12/2017
 * Time: 11:12
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MainController extends Controller
{

    public function homepageAction()
    {
        return $this->render('main/homepage.html.twig');
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
    public function contactAction(Request $request)
    {
        $post = new Post();
        $form = $this->get('form.factory')->createBuilder(formType::class, $post)
            ->add('author', TextType::class)
            ->add('content', TextareaType::class)
            //->add('Envoyer', SubmitType::class)
            ->getForm()
        ;

        if($request->isMethod('POST')) {

            $form->handleRequest($request);

            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($post);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Message bien enregistré.');
                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('main/contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }





}