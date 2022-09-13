<?php

namespace App\Controller;

use App\Entity\Disc;
use App\Repository\DiscRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(DiscRepository $discRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'discs' => $discRepository->findRecentDisc(),
        ]);
    }
}
