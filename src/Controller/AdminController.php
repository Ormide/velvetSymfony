<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/user', name:'app_admin_user')]
    public function user(UserRepository $userRepository): Response
    {
        return $this->render('admin/user.html.twig', [
            'user' => $userRepository->findAll()
        ]);
    }
    #[Route('/user/{id}', name:'app_admin_user_show', methods:['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/user_show.html.twig', [
            'user' => $user
        ]);
    }
}
