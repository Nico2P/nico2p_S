<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 08/01/2018
 * Time: 15:04
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * @Route("/projects")
     */
    public function projectAction()
    {
        return $this->render('project/projects.html.twig');
    }

    /**
     * @Route("/projects/add")
     */
    public function projectAdd()
    {
        return $this->render('project/projects.html.twig');
    }

    /**
     * @Route("/projects/edit/{id}")
     */
    public function projectEdit($id)
    {
        return $this->render('project/projects.html.twig');
    }
    /**
     * @Route("/projects/delete/{id}")
     */
    public function projectDelete($id)
    {
        return $this->render('project/projects.html.twig');
    }

}