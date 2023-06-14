<?php

namespace App\Controller;

use App\Repository\AromeRepository;
use App\Repository\ColorRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gout', name: 'gout_')]
class GoutController extends AbstractController
{
    /**
     * @param AromeRepository $aromeRepository
     * @param RegionRepository $regionRepository
     * @param ColorRepository $colorRepository
     * @return Response
     */
    #[Route('/', name: 'app_gout')]
    public function index(
        AromeRepository $aromeRepository,
        RegionRepository $regionRepository,
        ColorRepository $colorRepository
    ): Response {

        $arome = $aromeRepository->findAll();
        $region = $regionRepository->findAll();
        $color = $colorRepository->findAll();

        return $this->render('gout/index.html.twig', [
            'arome' => $arome,
            'region' => $region,
            'color' => $color
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(): Response
    {

        return $this->render('gout/new.html.twig');
    }

    #[Route('/show', name: 'show')]
    public function show(): response
    {
        return $this->render('gout/show.html.twig');
    }
}
