<?php

namespace App\Controller;

use App\Entity\Workshop;
use App\Repository\WineBlendRepository;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WinnerController extends AbstractController
{
    #[Route('/winner/{codeWorkshop}', name: 'app_winner')]
    public function show(
        Workshop $workshop,
        WorkshopRepository $workshopRepository,
        WineBlendRepository $wineBlendRepository
    ): Response {

        $numberOfBlends = $wineBlendRepository->countByWorkshop($workshop);
        $highestScore = $wineBlendRepository->findHighestScore();

        return $this->render('winner/show.html.twig', [
            'controller_name' => 'WinnerController',
            'numberOfBlends' => $numberOfBlends,
            'highestScore' => $highestScore,
        ]);
    }
}
