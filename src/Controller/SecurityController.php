<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, FileUploader $fileUploader, MailerInterface $mailer)
    {
        $user = new User();

        $registrationForm = $this->createForm(RegistrationType::class, $user);

        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
			$user->setActivationToken(md5(uniqid()));
			$fileUploader->uploadAvatar($user);
            $manager->persist($user);
            $manager->flush();
			$email = (new TemplatedEmail())
				->from('claire.coubard@gmail.com')
				->to($user->getEmail())
				->subject('Activation de votre compte SnowTricks!')
				->htmlTemplate('security/activation.html.twig')
				->context([
					'token' => $user->getActivationToken()
				])
			;
			$mailer->send($email);
            $this->addFlash('success', 'Votre inscription a bien été prise en compte ! <br/> Un email de confirmation vient de vous être envoyé.');
            return $this->redirectToRoute('login');
        }

        return $this->render('security/registration.html.twig', [
            'registrationForm' => $registrationForm->createView()
        ]);
    }

	/**
	 * @Route("/activation/{token}", name="activation")
	 */
	public function activation($token, UserRepository $repo, EntityManagerInterface $manager)
	{

		// On recherche si un utilisateur avec ce token existe dans la base de données
		$user = $repo->findOneBy(['activation_token' => $token]);

		// Si aucun utilisateur n'est associé à ce token
		if(!$user){
			// On renvoie une erreur 404
			throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
		}

		// On supprime le token
		$user->setActivationToken(null);
		$user->setActivatedToken(1);
		$manager->persist($user);
		$manager->flush();

		// On génère un message
		$this->addFlash('message', 'Votre compte a bien été activé ! Vous pouvez désormais vous connecter \o/');

		// On retourne à l'accueil
		return $this->redirectToRoute('login', [
			'user' => $user
		]);
	}

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
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
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
