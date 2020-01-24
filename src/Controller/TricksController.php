<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
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
	public function createTrick(Request $request)
	{
		$trick = new Trick();

		$form = $this->createForm(TrickType::class, $trick);

		return $this->render('tricks/createTrick.html.twig', [
			'form' => $form->createView()
		]);
	}







}
