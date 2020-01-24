<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('tricks/home.html.twig');
    }

	/**
	 * @Route("/creer", name="createTrick")
	 */
	public function createTrick(Request $request, EntityManagerInterface $manager)
	{
		$trick = new Trick();

		$form = $this->createForm(TrickType::class, $trick);

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()) {
			$manager->persist($trick);
			$manager->flush();
		}

		return $this->render('tricks/createTrick.html.twig', [
			'form' => $form->createView()
		]);
	}







}
