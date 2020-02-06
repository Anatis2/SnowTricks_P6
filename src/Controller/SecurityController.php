<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
	/**
	 * @Route("/inscription", name="registration")
	 */
	public function registration(Request $request, EntityManagerInterface $manager)
	{
		$user = new User();

		$registrationForm = $this->createForm(RegistrationType::class, $user);

		$registrationForm->handleRequest($request);

		if($registrationForm->isSubmitted() && $registrationForm->isValid()) {
			$manager->persist($user);
			$manager->flush();
		}

		return $this->render('security/registration.html.twig', [
			'registrationForm' => $registrationForm->createView()
		]);
	}

    /**
     * @Route("/connexion", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
        	'last_username' => $lastUsername,
			'error' => $error
		]);
    }

    /**
     * @Route("/déconnexion", name="logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
