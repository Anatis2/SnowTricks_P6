<?php

namespace App\Controller\admin;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
			/**
			 * @var UploadedFile $pictureFile
			 */
        	$pictureFile = $form->get('picture')->getData(); // On créée la variable $pictureFile, que l'on récupère de TrickType, et qui est de type UploadedFile

			if ($pictureFile) { // Si le champ 'picture' a été rempli (et donc si $pictureFile existe)
				$originalPictureFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME); // Alors, on récupère le nom original de l'image, grâce à son chemin d'accès
				$safePictureFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalPictureFilename); // On transforme le nom original en nom sécurisé
				$newPictureFileName = $safePictureFileName.'-'.uniqid().'.'.$pictureFile->guessExtension(); // On donne un nom final complet à notre fichier (comprenant un id unique, son extension, ...)
				try {
					$pictureFile->move( // On envoie le fichier $newPictureFileName vers le dossier 'public/images'
						$this->getParameter('pictures_directory'),
						$newPictureFileName
					);
				} catch (FileException $e) {
					return new Response("Il y a eu un problème lors du déplacement du fichier vers le dépôt");
				}
				$trick->setPictureFilename($newPictureFileName); // on met à jour le contenu de la propriété $pictureFileName de notre entité Trick
			}

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
