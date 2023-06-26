<?php

namespace App\Controller;

use App\Entity\WineBlend;
use App\Form\WineBlendType;
use App\Repository\WineBlendRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/new', name: 'app_wine_blend_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WineBlendRepository $wineBlendRepository): Response
    {
        $wineBlend = new WineBlend();
        $form = $this->createForm(WineBlendType::class, $wineBlend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wineBlendRepository->save($wineBlend, true);

            return $this->redirectToRoute('app_wine_blend_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wine_blend/new.html.twig', [
            'wine_blend' => $wineBlend,
            'form' => $form,
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
        if ($this->isCsrfTokenValid('delete'.$wineBlend->getId(), $request->request->get('_token'))) {
            $wineBlendRepository->remove($wineBlend, true);
        }

        return $this->redirectToRoute('app_wine_blend_index', [], Response::HTTP_SEE_OTHER);
    }
}
