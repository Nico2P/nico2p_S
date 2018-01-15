<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 08/01/2018
 * Time: 15:04
 */

namespace AppBundle\Controller;

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

class ProjectController extends Controller
{
    /**
     * @Route("/projects", name="projects", requirements={})
     */
    public function projectAction()
    {

        $projects = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Project')
            ->findBy([], ['date' => 'ASC']);

        if ($projects === null) {
            throw new NotFoundHttpException("Liste de projets vide :( ");
        }

        return $this->render('project/projects.html.twig', array(
            'projects' => $projects
        ));
    }

    /**
     * @Route("/projects/add")
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
        return $this->render('project/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/projects/edit/{id}" , requirements={"id": "\d+"})
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

        return $this->render('project/edit.html.twig', array(
            'project' => $project,
            'form'  =>$form->createView(),
        ));
    }

    /**
     * @Route("/projects/delete/{id}")
     * @Method("delete")
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


        return $this->render('project/delete.html.twig', array(
            'project' => $project,
            'form'  =>$form->createView(),
        ));
    }

}
