<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\Message;
use App\Form\TrickType;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use App\Repository\TrickRepository;
use App\Services\CommentsLoader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(TrickRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $tricks = $paginator->paginate(
            $repo->findAll(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('tricks/home.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/figure/{id}", name="showTrick",
	 *     requirements={"id" = "\d+"},
	 *	   defaults={"id" = 1}
	 * )
     */
    public function show(Trick $trick, Request $request, EntityManagerInterface $manager)
    {
        $message = new Message($trick);

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setUser($this->getUser());
            $manager->persist($message);
            $manager->flush();
			$this->addFlash('notice', 'Votre commentaire a bien été enregistré !');
			return $this->redirect("/figure/" . $trick->getId());
        }

        return $this->render('tricks/showTrick.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

	/**
	 * @Route("/figure/testMessages", name="loadMessages")
	 */
    public function loadMessages(Message $messages, Request $request, EntityManagerInterface $manager)
	{
		return $this->render('tricks/showTrick.html.twig', [
			'messages' => $messages
		]);
	}

}
