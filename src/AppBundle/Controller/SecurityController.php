<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 15/01/2018
 * Time: 15:05
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
          return $this->redirectToRoute('homepage');
        }

        $authetivationUtils = $this->get('security.authentication_utils');

        return $this->render('security/login.html.twig', array(
            'last_username' => $authetivationUtils->getLastUsername(),
            'error' => $authetivationUtils->getLastAuthenticationError(),
        ));
    }
    
    
}