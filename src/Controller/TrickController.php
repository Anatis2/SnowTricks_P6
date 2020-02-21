<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
			4
		);

        return $this->render('tricks/home.html.twig', [
			'tricks' => $tricks
		]);
    }

	/**
	 * @Route("/figure/{id}", name="showTrick")
	 */
    public function show(Trick $trick)
	{
		return $this->render('tricks/showTrick.html.twig', [
			'trick' => $trick,
		]);
	}

}
