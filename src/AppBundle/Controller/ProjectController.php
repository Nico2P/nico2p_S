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


}
