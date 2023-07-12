<?php

namespace App\Controller;

use App\Entity\Workshop;
use App\Repository\WineBlendRepository;
use App\Repository\WorkshopRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PreVoteLoaderController extends AbstractController
{
    #[Route('/prevote/{codeWorkshop}', name: 'app_prevote_loader', methods: ['GET'])]
    public function preVoteLoader(
        WorkshopRepository $workshopRepository,
        WineBlendRepository $wineBlendRepository,
        Workshop $workshop,
        int $codeWorkshop,
    ): response {
        $currentWorkshop = $workshopRepository->findBy(['codeWorkshop' => $codeWorkshop]);
        $workshopId = $currentWorkshop[0]->getId();
        $nbOfUsers = $wineBlendRepository->countUserByWS($workshopId);
        return $this->render(
            'pre_vote/show.html.twig',
            ['nbOfUsers' => $nbOfUsers,
                'codeWorkshop' => $codeWorkshop,
            ]
        );
        //$workshop = $this->getUser()->getWorkshop();

        //la page après validation
        /*return $this->redirectToRoute(
            'app_vote',
            ['codeWorkshop' => $workshop->getCodeWorkshop()],
            Response::HTTP_SEE_OTHER
        );*/

// la page d'affichage
        /*return $this->renderForm('wine_blend/new.html.twig', [
            'wine_blend' => $wineBlend,
            'wineBlendForm' => $wineBlendForm,
            'tastingSheets' => $tastingSheets,
            'workshop' => $workshop,
        ]);*/
    }
}
