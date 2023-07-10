<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Entity\Workshop;
use App\Form\VoteType;
use App\Repository\VoteRepository;
use JetBrains\PhpStorm\NoReturn;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends AbstractController
{
    #[Route('/vote/{codeWorkshop}', name: 'app_vote')]
    public function index(VoteRepository $voteRepository, Request $request, Workshop $workshop, Vote $vote): Response
    {
        $votesByWorkshop = $voteRepository->findBy(['workshop' => $workshop]);
        $voteFormBuilder = $this->createFormBuilder();

        foreach ($votesByWorkshop as $workshopVotes) {
            $voteFormBuilder->add('vote_' . $workshopVotes->getId(), VoteType::class, [
                'data' => $workshopVotes,
            ]);
        }

        $form = $voteFormBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voteRepository->save($vote, true);
            return $this->redirectToRoute('app_vote_loader');
        }

        return $this->render('vote/index.html.twig', [
            'form' => $form->createView(),
            'votes' => $votesByWorkshop,
            'voteForm' => $voteFormBuilder->getForm(),
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
