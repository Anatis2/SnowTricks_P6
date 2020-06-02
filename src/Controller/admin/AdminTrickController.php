<?php

namespace App\Controller\admin;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminTrickController extends AbstractController
{

    /**
     * @Route("/creation", name="createTrick")
     */
    public function createTrick(Request $request, EntityManagerInterface $manager, FileUploader $fileUploader)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

			/**
			 * @var UploadedFile $pictureFiles
			 */
        	$pictureFiles = $form->get('pictures')->getData(); // On récupère les éventuelles données de type UploadedFile (@var UploadedFile $pictureFiles), grâce à 'picture', qui provient de TrickType

			/*foreach ($pictureFiles as $pictureFile) {
				if ($pictureFile) { // Si le champ 'picture' a été rempli (et donc si $pictureFiles existe)
					$pictureFileName = $fileUploader->upload($pictureFile); // Alors on appelle le service FileUploader (via l'objet $fileUploader), que l'on stocke dans une variable ($pictureFilename)
					$trick->setPictureFileName($pictureFileName);
				}
			}*/


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
