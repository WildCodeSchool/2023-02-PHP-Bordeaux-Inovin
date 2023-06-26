<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Smell;
use App\Entity\Wine;
use App\Entity\Workshop;
use App\Entity\TastingSheet;

use App\Form\TastingSheetType;
use App\Repository\CommentRepository;
use App\Repository\TastingSheetRepository;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TastingSheetController extends AbstractController
{
    #[Route('/tastingSheet/{codeWorkshop}', name: 'app_tasting_sheet', methods: ['GET', 'POST'])]

    public function index(Workshop $workshop, Request $request, TastingSheetRepository $tastingSheetRepository): Response
    {
        $tastingSheets = [];
        $forms = [];


        for ($i = 1; $i <= 4; $i++) {
            $tastingSheet = new TastingSheet();
            $form = $this->createForm(TastingSheetType::class, $tastingSheet);
            $form->handleRequest($request);

            $tastingSheets[] = $tastingSheet;
            $forms[] = $form->createView();
        }
        if ($form->isSubmitted() && $form->isValid()) {
            // Traitez les données du formulaire

            $tastingSheet->setWorkshop($workshop);

            $selectedSmells = $form->get('smell')->getData();
            $selectedTastes = $form->get('taste')->getData();

            foreach ($selectedSmells as $smell) {
                $tastingSheet->addSmell($smell);
                $smell->addTastingSheet($tastingSheet);
            }
            foreach ($selectedTastes as $taste) {
                $tastingSheet->addTaste($taste);
                $taste->addTastingSheet($tastingSheet);
            }

            $tastingSheetRepository->save($tastingSheet, true);
        }


        return $this->render('tasting_sheet/index.html.twig', [
            'forms' => $forms,
            'tastingSheets' => $tastingSheets,
            'workshop' => $workshop,
        ]);
    }
    /*
    $wines = $workshop->getWines();
        // Utilisez $i - 1 car les tableaux sont indexés à partir de 0
    $tastingSheet->setWine($wines[$i - 1]);
    $selectedSmells = $form->get('smell')->getData();
    $selectedTastes = $form->get('taste')->getData();

    foreach ($selectedSmells as $smell) {
    $tastingSheet->addSmell($smell);
    $smell->addTastingSheet($tastingSheet);
    }
    foreach ($selectedTastes as $taste) {
        $tastingSheet->addTaste($taste);
        $taste->addTastingSheet($tastingSheet);
    }
    */
}
