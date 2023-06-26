<?php

namespace App\Controller;

use App\Entity\Workshop;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AtelierController extends AbstractController
{
    #[Route('/atelier', name: 'app_atelier')]
    public function atelier(): Response
    {
        return $this->render('atelier/welcome.html.twig');
    }
    #[Route('/submit-code', name: 'app_tasting_sheet', methods: ['POST'])]
    public function submitCode(Request $request): Response
    {
        $code = $request->request->get('code');

        return $this->redirectToRoute('app_tasting_sheet', ['code' => $code]);
    }
}
