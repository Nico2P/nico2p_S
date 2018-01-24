<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 08/01/2018
 * Time: 15:04
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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


}
