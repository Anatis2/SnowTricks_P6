<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
	public function createTrick()
	{

		$trick = new Trick();

		$form = $this->createFormBuilder($trick)
					 ->add('name')
					 ->add('description')
					 ->getForm();

		return $this->render('tricks/createTrick.html.twig', [
			'form' => $form->createView()
		]);
	}







}
