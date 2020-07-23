<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
   
    /**
     * @Route("/validation", name="security_validation")
     */
    public function validation()
    {
        return $this->render('security/validation.html.twig');
    }
    /**
     * @Route("/", name="security_login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }

    /**
    * @Route("/deconnexion", name="security_logout")
    */
   public function logout(){}

}
