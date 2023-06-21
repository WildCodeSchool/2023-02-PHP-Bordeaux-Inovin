<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TastingSheetController extends AbstractController
{
    #[Route('/tasting/sheet', name: 'app_tasting_sheet')]
    public function index(): Response
    {
        return $this->render('tasting_sheet/index.html.twig', [
            'controller_name' => 'TastingSheetController',
        ]);
    }
}
