<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends AbstractController
{
    #[Route('/vote', name: 'app_vote')]
    public function index(): Response
    {
        return $this->render('vote/index.html.twig', [
            'controller_name' => 'VoteController',
        ]);
    }

#[Route('/vote/loader', name: 'app_vote_loader')]
    public function loader(): Response
    {
        return $this->render('vote/loader.html.twig', [
            'controller_name' => 'VoteController',
        ]);
}
}

