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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin")
 * @isGranted("ROLE_USER")
 */
class AdminTrickController extends AbstractController
{

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
     * @Route("/creation", name="createTrick")
     */
    public function createTrick(Request $request, EntityManagerInterface $manager, FileUploader $fileUploader)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        	$trick->setUser($this->getUser());

            /**
             * @var UploadedFile $file
             */
            foreach ($trick->getPictures() as $picture) {
                $fileUploader->upload($picture);
            };

            foreach ($trick->getVideos() as $video) {
                $code = substr($video->getUrl(), 7);
                $video->setUrl($code);
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
     * @Route("/edition/{name}", name="editTrick")
     */
    public function editTrick(Trick $trick, Request $request, EntityManagerInterface $manager, FileUploader $fileUploader)
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var UploadedFile $file
             */
            foreach ($trick->getPictures() as $picture) {
                $fileUploader->upload($picture);
            };

            foreach ($trick->getVideos() as $video) {
                $code = substr($video->getUrl(), 7);
                $video->setUrl($code);
            }

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash('success', 'La figure a été modifiée avec succès !');
            return $this->redirectToRoute('adminHome');
        }
        return $this->render('admin/adminEditTrick.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/suppression/{name}", name="deleteTrick")
     */
    public function deleteTrick(Trick $trick, Request $request, EntityManagerInterface $manager)
    {
        if ($this->isCsrfTokenValid('delete' . $trick->getName(), $request->get('_token'))) {
            $manager->remove($trick);
            $manager->flush();
            $this->addFlash('success', 'La figure a été supprimée avec succès !');
            return $this->redirectToRoute('adminHome');
        }
    }

}
