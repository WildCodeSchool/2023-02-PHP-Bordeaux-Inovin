<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Entity\Workshop;
use App\Form\VoteType;
use App\Repository\VoteRepository;
use App\Repository\WineBlendRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends AbstractController
{
    #[Route('/vote/{codeWorkshop}', name: 'app_vote')]
    public function index(
        VoteRepository      $voteRepository,
        Request             $request,
        Workshop            $workshop,
        WineBlendRepository $blendRepository
    ): Response
    {

        $votesByWorkshop = $blendRepository->findBy(['workshop' => $workshop]);
        $voteFormBuilder = $this->createFormBuilder();
        $formSaves = [];
        foreach ($votesByWorkshop as $voteByWorkshop) {
            $newVote = new Vote();
            $newVote->setWineBlend($voteByWorkshop);
            $newVote->setUser($this->getUser());
            $newVote->setWorkshop($workshop);

            $voteFormBuilder->add('vote_' . $voteByWorkshop->getId(), VoteType::class, [
                'data' => $newVote,
            ]);
        }

        $form = $voteFormBuilder->getForm();
        $form->handleRequest($request);
        $formSaves = $form->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            array_map(function ($formSave) use ($voteRepository) {
                $voteRepository->save($formSave, true);
            }, $formSaves);

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
