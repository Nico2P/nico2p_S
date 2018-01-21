<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 16/01/2018
 * Time: 15:47
 */

namespace AppBundle\Controller\Admin;

use AppBundle\AppBundle;
use AppBundle\Entity\Image;
use AppBundle\Entity\Project;
use AppBundle\Form\ProjectEditType;
use AppBundle\Form\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     * @Method({"GET", "POST"})
     *@Security("has_role('ROLE_AUTEUR')")
     */
    public function adminAction(Request $request)
    {
        $projects = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Project')
            ->findBy([], ['date' => 'ASC']);

        $posts = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Post')
            ->findBy([], ['date' => 'ASC']);

        if ($projects === null) {
            throw new NotFoundHttpException("Liste de projets vide :( ");
        }

        return $this->render('admin/panel.html.twig', array(
            'projects' => $projects, 'posts' => $posts
        ));
    }



    /**
     * @Route("/admin/projects/add" , name="projects_add")
     * @Method({"GET", "POST"})
     *@Security("has_role('ROLE_AUTEUR')")
     */
    public function projectAdd(Request $request)
    {
        $project = new Project();
        $form   = $this->get('form.factory')->create(ProjectType::class, $project);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            return $this->redirectToRoute('projects');
        }
        return $this->render('admin/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/projects/edit/{id}" , name="project_edit", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_AUTEUR')")
     *
     */
    public function projectEdit($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $project = $em->getRepository("AppBundle:Project")->find($id);


        if ($project === null) {
            throw new NotFoundHttpException("Project introuvable :( ");
        }

        // FORMULAIRE
        $form = $this->get('form.factory')->create(ProjectEditType::class, $project);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Project modifié');

            return $this->redirectToRoute('projects');
        }

        return $this->render('admin/edit.html.twig', array(
            'project' => $project,
            'form'  =>$form->createView(),
        ));
    }

    /**
     * @Route("/admin/projects/delete/{id}" , name="project_delete", requirements={"id": "\d+"})
     *@Security("has_role('ROLE_AUTEUR')")
     */
    public function projectDelete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository("AppBundle:Project")->find($id);


        if ($project === null) {
            throw new NotFoundHttpException("Project introuvable :( ");
        }

        $form = $this->get('form.factory')->create();

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($project);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Project supprimé');

            return $this->redirectToRoute('projects');
        }


        return $this->render('admin/delete.html.twig', array(
            'project' => $project,
            'form'  =>$form->createView(),
        ));
    }

    /**
     * @Route("/admin/post/delete/{id}" , name="post_delete", requirements={"id": "\d+"})
     *@Security("has_role('ROLE_AUTEUR')")
     */
    public function postDelete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository("AppBundle:Post")->find($id);


        if ($post === null) {
            throw new NotFoundHttpException("Post introuvable :( ");
        }

        $form = $this->get('form.factory')->create();

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($post);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Message supprimé');

            return $this->redirectToRoute('admin');
        }


        return $this->redirectToRoute('admin');
    }


}