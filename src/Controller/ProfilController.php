<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(('/profil'))]
class ProfilController extends AbstractController
{
    #[Route('/', name:'profil')]
    public function index() :Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        /** @var User $user */
        $user = $this->getUser();
        $user->birthday = date_format($user->getBirthday(), 'd/m/Y');

        return $this->render('profil/detail.html.twig', [
            'user' => $user
        ]);
    }
    #[Route('/edit', name: 'app_profil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository, FileUploader $fileUploader): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['picture2']->getData(); //Récupération des infos de l'upload
            $id = $user->getId();
            $name = $user->getEmail();

            if ($file) {
                $userPicture = $fileUploader->uploadID($file, 'user', $id, $name);
                $user->setPicture($userPicture);
            }

            $userRepository->add($user, true);

            return $this->redirectToRoute('profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}