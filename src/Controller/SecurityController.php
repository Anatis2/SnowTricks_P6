<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="registration")
     */
    public function registration()
    {
        return $this->render('security/registration.html.twig');
    }

	/**
	 * @Route("/connexion", name="login")
	 */
	public function login()
	{
		return $this->render('security/login.html.twig');
	}

}
