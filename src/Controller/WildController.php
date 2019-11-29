<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

class WildController extends AbstractController
{
    /**
     * @Route("/wild", name="wild_index")
     */
    public function index(ProgramRepository $programRepository)
    {
        $programs = $programRepository->findAll();

        if (!$programs) {
          throw $this->createNotFoundException('No program found in program\'s table.');
        }

        return $this->render('wild/index.html.twig', ['programs' => $programs]);
    }

    /**
     * @Route("/wild/show/{slug<[a-z0-9-]+>}", defaults={"slug" = null}, name="wild_show")
     */
    public function show(?string $slug, ProgramRepository $programRepository)
    {
        if (!$slug) {
            throw $this
            ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        
        $showName = str_replace('-', ' ', $slug);
        $showName = ucwords($showName);
        $program = $programRepository->findOneBy(['title' => mb_strtolower($showName)]);

        return $this->render('wild/show.html.twig', [
            'showName' => $showName,
            'program' => $program
        ]);
    }
}
