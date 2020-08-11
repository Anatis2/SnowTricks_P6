<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EnterNewPwdType;
use App\Form\RegistrationType;
use App\Form\ResetPassType;
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
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
            $user->setRoles(['ROLE_USER']);
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
        if (!$user) {
			$this->addFlash('danger', "Impossible de confirmer la création de votre compte. <br/> 
													 Vérifiez que votre le compte n'a pas déjà été activé, en essayant de vous connecter.");
			return $this->redirectToRoute('login');
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

    /**
     * @Route("/password", name="forgotPassword")
     */
    public function forgotPassword(Request $request, UserRepository $repo, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $manager, MailerInterface $mailer)
    {
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = $repo->findOneBy(['email' => $data['email']]);

            if ($user === null) {
                $this->addFlash('danger', 'Cette adresse e-mail est inconnue');
                return $this->redirectToRoute('login');
            }

            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $manager->persist($user);
                $manager->flush();
            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());
                return $this->redirectToRoute('login');
            }

            // On génère l'URL de réinitialisation de mot de passe
            $url = $this->generateUrl('resetPassword', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            // On génère l'email
            $email = (new TemplatedEmail())
                ->from('claire.coubard@gmail.com')
                ->to($user->getEmail())
                ->subject('Activation de votre compte SnowTricks!')
                ->htmlTemplate('security/resetPwdMail.html.twig')
                ->context([
                    'url' => $url,
                    'token' => $token
                ]);

            $mailer->send($email);
            $this->addFlash('message', 'Un email vient de vous être envoyé. Veuillez le consulter pour pouvoir réinitialiser votre mot de passe.');
            return $this->redirectToRoute('login');
        }

        return $this->render('security/forgotPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/resetPassword/{token}", name="resetPassword")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder, UserRepository $repo, EntityManagerInterface $manager)
    {
        $form = $this->createForm(EnterNewPwdType::class);
        $form->handleRequest($request);

        $user = $repo->findOneBy(['reset_token' => $token]);

        // Si l'utilisateur n'existe pas
        if ($user === null) {
            // On affiche une erreur
            $this->addFlash('danger', 'Token inconnu !');
            return $this->redirectToRoute('login');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // On supprime le token
            $user->setResetToken(null);
            // On chiffre le mot de passe
            $password = $passwordEncoder->encodePassword($user, $data['password']);
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();
            $this->addFlash('message', 'Votre mot de passe a été mis à jour. <br/> Vous pouvez vous connecter avec votre nouveau mot de passe');
            return $this->redirectToRoute('login');
        } else {
            // Si on n'a pas reçu les données, on affiche le formulaire
            return $this->render('security/resetPassword.html.twig', [
                'token' => $token,
                'form' => $form->createView()
            ]);
        }
    }
}
