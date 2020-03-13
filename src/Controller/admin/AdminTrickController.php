<?php

namespace App\Controller\admin;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminTrickController extends AbstractController
{

    /**
     * @Route("/creation", name="createTrick")
     */
    public function createTrick(Request $request, EntityManagerInterface $manager)
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($trick);
            $manager->flush();

            $this->addFlash('success', 'La figure a été créée avec succès !');
            return $this->redirectToRoute('adminHome');
        }

        return $this->render('admin/adminCreateTrick.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/administration", name="adminHome")
     */
    public function adminHome(TrickRepository $repo)
    {
        $tricks = $repo->findAll();

        return $this->render('admin/adminHome.html.twig', [
            'tricks' => $tricks
        ]);
    }


    /**
     * @Route("/edition/{id}", name="editTrick")
     */
    public function editTrick(Trick $trick, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', 'La figure a été modifiée avec succès !');
            return $this->redirectToRoute('adminHome');
        }

        return $this->render('admin/adminEditTrick.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/suppression/{id}", name="deleteTrick")
     */
    public function deleteTrick(Trick $trick, Request $request, EntityManagerInterface $manager)
    {
        if ($this->isCsrfTokenValid('delete' . $trick->getId(), $request->get('_token'))) {
            $manager->remove($trick);
            $manager->flush();
            $this->addFlash('success', 'La figure a été supprimée avec succès !');
        }

        return $this->redirectToRoute('adminHome');
    }
}
