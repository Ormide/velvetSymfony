<?php

namespace App\Controller;

use App\Entity\Disc;
use App\Form\NewDiscType;
use Doctrine\Persistence\ManagerRegistry;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscsController extends AbstractController
{
    #[Route('/disc', name: 'disc_list')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $disc = $doctrine->getRepository(Disc::class)->findAll();
        $tableLength = count($disc);
        return $this->render('discs/index.html.twig', [
            'controller_name' => 'DiscsController',
            'disc' => $disc,
            'many' => $tableLength,
        ]);
    }

    #[Route('/disc/detail/{id}', name: 'disc_detail')]
    public function detail($id, ManagerRegistry $doctrine): Response
    {
        $disc = $doctrine->getRepository(Disc::class)->Find($id);
        return $this->render('discs/detail.html.twig',
            ['disc' => $disc,
            ]);
    }

    /**
     * @Route("/disc/new", name="NewDisc")
     * @param Request $request
     * @return Response
     */
    public function new(): Response
    {
        $disc = new Disc();

        $form = $this->createForm(NewDiscType::class, $disc);

        return $this->render('/discs/new.html.twig', [
            'disc' => $disc,
            'form' => $form->createView(),
        ]);
    }
}