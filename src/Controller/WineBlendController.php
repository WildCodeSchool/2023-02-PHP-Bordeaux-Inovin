<?php

namespace App\Controller;

use App\Entity\WineBlend;
use App\Entity\Workshop;
use App\Form\WineBlendType;
use App\Repository\TastingSheetRepository;
use App\Repository\WineBlendRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/wine/blend')]
class WineBlendController extends AbstractController
{
    #[Route('/', name: 'app_wine_blend_index', methods: ['GET'])]
    public function index(WineBlendRepository $wineBlendRepository): Response
    {
        return $this->render('wine_blend/index.html.twig', [
            'wine_blends' => $wineBlendRepository->findAll(),
        ]);
    }

    #[Route('/new/{codeWorkshop}', name: 'app_wine_blend_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        WineBlendRepository $wineBlendRepository,
        SessionInterface $session,
        Workshop $workshop,
        TastingSheetRepository $tastingSheetRepo,
    ): Response {
        $session->set('countValidateForm', 0);
        $wineBlend = new WineBlend();
        $wineBlendForm = $this->createForm(WineBlendType::class, $wineBlend);
        $wineBlendForm->handleRequest($request);

        $tastingSheets = $tastingSheetRepo->findBy(['workshop' => $workshop, 'user' => $this->getUser()]);

        if ($wineBlendForm->isSubmitted() && $wineBlendForm->isValid()) {
            $wineBlend->setUser($this->getUser());
            $wineBlend->setWorkshop($workshop);
            $wineBlendRepository->save($wineBlend, true);

            return $this->redirectToRoute('app_winner', [
                'workshopId' => $workshop->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wine_blend/new.html.twig', [
            'wine_blend' => $wineBlend,
            'wineBlendForm' => $wineBlendForm,
            'tastingSheets' => $tastingSheets,
            'workshop' => $workshop,
        ]);
    }

    #[Route('/{id}', name: 'app_wine_blend_show', methods: ['GET'])]
    public function show(WineBlend $wineBlend): Response
    {
        return $this->render('wine_blend/show.html.twig', [
            'wine_blend' => $wineBlend,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_wine_blend_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WineBlend $wineBlend, WineBlendRepository $wineBlendRepository): Response
    {
        $form = $this->createForm(WineBlendType::class, $wineBlend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wineBlendRepository->save($wineBlend, true);

            return $this->redirectToRoute('app_wine_blend_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wine_blend/edit.html.twig', [
            'wine_blend' => $wineBlend,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_wine_blend_delete', methods: ['POST'])]
    public function delete(Request $request, WineBlend $wineBlend, WineBlendRepository $wineBlendRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $wineBlend->getId(), $request->request->get('_token'))) {
            $wineBlendRepository->remove($wineBlend, true);
        }

        return $this->redirectToRoute('app_wine_blend_index', [], Response::HTTP_SEE_OTHER);
    }
}
