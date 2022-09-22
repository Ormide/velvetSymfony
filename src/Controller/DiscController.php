<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Disc;
use App\Entity\User;
use App\Form\DiscType;
use App\Repository\CommentsRepository;
use App\Repository\DiscRepository;
use App\Service\FileDirectory;
use App\Service\FileUploader;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/disc')]
class DiscController extends AbstractController
{
    #[Route('/', name: 'app_disc_index', methods: ['GET'])]
    public function index(DiscRepository $discRepository): Response
    {
        return $this->render('disc/index.html.twig', [
            'discs' => $discRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_disc_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DiscRepository $discRepository, FileUploader $fileUploader, FileDirectory $fileDirectory): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $disc = new Disc();
        $form = $this->createForm(DiscType::class, $disc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //récupération de la date d'ajout
            $date = new DateTime();
            $disc->setDateAjout($date);

            $discPicture = $form['picture2']->getData(); //Récupération des infos de l'upload

            if ($discPicture) {
                $name = $form['title']->getData();
                $filename = $fileUploader->upload($discPicture, $fileDirectory->getDiscDirectory(), $name);
                $disc->setPicture($filename);
            } 

            $discRepository->add($disc, true);

            return $this->redirectToRoute('app_disc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disc/new.html.twig', [
            'disc' => $disc,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_disc_show', methods: ['GET'])]
    public function show(Disc $disc, CommentsRepository $commentsRepository): Response
    {
        $user = $this->getUser();

        return $this->render('disc/show.html.twig', [
            'disc' => $disc,
            'comment' => $commentsRepository->findCommentDisc($disc),
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_disc_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Disc $disc, DiscRepository $discRepository, FileUploader $fileUploader, FileDirectory $fileDirectory): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(DiscType::class, $disc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $discPicture = $form['picture2']->getData(); //Récupération des infos de l'upload

            if ($discPicture) {
                $name = $form['title']->getData();
                $filename = $fileUploader->upload($discPicture, $fileDirectory->getDiscDirectory(), $name);
                $disc->setPicture($filename);
            }
            
            $discRepository->add($disc, true);

            return $this->redirectToRoute('app_disc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disc/edit.html.twig', [
            'disc' => $disc,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_disc_delete', methods: ['POST'])]
    public function delete(Request $request, Disc $disc, DiscRepository $discRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        if ($this->isCsrfTokenValid('delete'.$disc->getId(), $request->request->get('_token'))) {
            $discRepository->remove($disc, true);
        }

        return $this->redirectToRoute('app_disc_index', [], Response::HTTP_SEE_OTHER);
    }
}
