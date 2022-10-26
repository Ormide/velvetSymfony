<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(('/profil'))]
class ProfilController extends AbstractController
{
    #[Route('/', name:'profil')]
    public function index() :Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('profil/index.html.twig', []);
    }
    
    #[Route('/edit', name: 'app_profil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository, FileUploader $fileUploader, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        /** @var User $user */
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['picture2']->getData(); //Récupération des infos de l'upload
            $id = $user->getId();
            $name = $user->getEmail();

            if ($file) {
                $userPicture = $fileUploader->uploadID($file, 'user', $id, $name);
                $user->setPicture($userPicture);
            }

            $password = $form['password']->getData();
            if ($password) {
                $user->setPassword(
                    $userPasswordHasherInterface->hashPassword($user, $password)
                );
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