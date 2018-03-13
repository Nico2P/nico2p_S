<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 14/12/2017
 * Time: 11:12
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Commentary;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class MainController extends Controller
{

    /**
     * @Route("/" , name="homepage")
     */
    public function homepageAction()
    {
        return $this->render('main/homepage.html.twig');
    }


    /**
     * @Route("/cv" , name="cv")
     */
    public function cvAction()
    {
        return $this->render('main/curriculum.html.twig');
    }

    /**
     * @Route("/more" , name="moreinfo")
     */
    public function InfoAction()
    {
        return $this->render('main/more.html.twig');
    }

    /**
     * @Route("/contact" , name="contact")
     */
    public function contactAction(Request $request)
    {
        $post = new Post();
        $form   = $this->get('form.factory')->create(PostType::class, $post);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $transport = \Swift_MailTransport::newInstance();

            $mailer = \Swift_Mailer::newInstance($transport);

            $mail = (new \Swift_Message('Message de ' . $post->getAuthor()))
                ->setFrom($post->getEmail())
                ->setTo('contact@nico2p.com')
                ->setDate($post->getDate()->format('Y-m-d H:i:s'))
                ->setBody($post->getContent())
            ;

            $mailer->send($mail);

            //$this->get('mailer')->send($mail);

            $this->addFlash(
                'notice',
                'Mail Envoyé !'
            );

            return $this->redirectToRoute('contact');

        }
        return $this->render('main/contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }



    /**
     * @Route("/message" , name="message")
     *
     */
    public function showMessageAction(Request $request)
    {


        if (isset($_POST['author']) && $_POST['message']) {

            if ($request->isMethod('POST')) {
                $commentary = new Commentary();
                $commentary_author = htmlspecialchars($_POST['author']);
                $commentary_content = htmlspecialchars($_POST['message']);
                $commentary->setAuthor($commentary_author);
                $commentary->setContent($commentary_content);
                $em = $this->getDoctrine()->getManager();
                $em->persist($commentary);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Message enregistré!'
                );

                return $this->redirectToRoute("message");
            }


        }
        return $this->render('main/message.html.twig');
    }




    /**
     * @Route("/commentary" , name="commentary")
     * @Method({"GET", "POST"})
     */
    public function getMessageAction(Request $request)
    {
        $commentary_list = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Commentary')
            ->findBy([], ['date' => 'DESC']);

        if ($commentary_list === null) {
            throw new NotFoundHttpException("Liste de commentaire vide :( ");
        }

        return new JsonResponse($commentary_list);

    }





}