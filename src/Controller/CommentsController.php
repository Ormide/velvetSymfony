<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Disc;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class CommentsController extends AbstractController
{
    #[Route('/disc/{id}/newcomments', name: 'app_comments_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommentsRepository $commentsRepository, Disc $disc): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $comment = new Comments();
        $date = new DateTime();
        $user = $this->getUser();

        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setDate($date);
            $comment->setUser($user);
            $comment->setDisc($disc);
            $commentsRepository->add($comment, true);

            return $this->redirectToRoute('app_disc_show', ['id' => $disc->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/_form.html.twig', [
            'disc' => $disc,
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/comments/{id}/edit', name: 'app_comments_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comments $comment, CommentsRepository $commentsRepository): Response
    {
        $this->denyAccessUnlessGranted('edit', $comment, 'Vous êtes pas l\'auteur du commentaire');

        $date = new DateTime();
        $disc = $comment->getDisc();

        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUpdateDate($date);
            $commentsRepository->add($comment, true);

            return $this->redirectToRoute('app_disc_show', ['id' => $disc->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'disc' => $disc,
        ]);
    }

    #[Route('/comments/{id}', name: 'app_comments_delete', methods: ['POST'])]
    public function delete(Request $request, Comments $comment, CommentsRepository $commentsRepository): Response
    {
        $disc = $comment->getDisc();
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $commentsRepository->remove($comment, true);
        }

        return $this->redirectToRoute('app_disc_show', ['id' => $disc->getId()], Response::HTTP_SEE_OTHER);
    }
}
