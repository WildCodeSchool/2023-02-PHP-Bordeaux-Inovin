<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Smell;
use App\Entity\Wine;
use App\Entity\Workshop;
use App\Entity\TastingSheet;
use App\Form\TastingSheetType1;
use App\Form\TastingSheetType2;
use App\Form\TastingSheetType3;
use App\Form\TastingSheetType4;
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
    public function index(
        Workshop $workshop,
        Request $request,
        TastingSheetRepository $tastingSheetRepository
    ): Response {
        $tastingSheets = [];
        $forms = [];

        $tastingSheet1 = new TastingSheet();
        $form1 = $this->createForm(TastingSheetType1::class, $tastingSheet1);
        $form1->handleRequest($request);
        $tastingSheets[] = $tastingSheet1;
        $forms[] = $form1->createView();


        $tastingSheet2 = new TastingSheet();
        $form2 = $this->createForm(TastingSheetType2::class, $tastingSheet2);
        $form2->handleRequest($request);
        $tastingSheets[] = $tastingSheet2;
        $forms[] = $form2->createView();

        $tastingSheet3 = new TastingSheet();
        $form3 = $this->createForm(TastingSheetType3::class, $tastingSheet3);
        $form3->handleRequest($request);
        $tastingSheets[] = $tastingSheet3;
        $forms[] = $form3->createView();

        $tastingSheet4 = new TastingSheet();
        $form4 = $this->createForm(TastingSheetType4::class, $tastingSheet4);
        $form4->handleRequest($request);
        $tastingSheets[] = $tastingSheet4;
        $forms[] = $form4->createView();

        if ($form1->isSubmitted() && $form1->isValid()) {
            // Traitez les données du formulaire

            $tastingSheet1->setWorkshop($workshop);

            $selectedSmells = $form1->get('smell')->getData();
            $selectedTastes = $form1->get('taste')->getData();

            foreach ($selectedSmells as $smell) {
                $tastingSheet1->addSmell($smell);
                $smell->addTastingSheet($tastingSheet1);
            }
            foreach ($selectedTastes as $taste) {
                $tastingSheet1->addTaste($taste);
                $taste->addTastingSheet($tastingSheet1);
            }

            $tastingSheetRepository->save($tastingSheet1, true);
        }

        if ($form2->isSubmitted() && $form2->isValid()) {
            // Traitez les données du formulaire

            $tastingSheet2->setWorkshop($workshop);

            $selectedSmells = $form2->get('smell')->getData();
            $selectedTastes = $form2->get('taste')->getData();

            foreach ($selectedSmells as $smell) {
                $tastingSheet2->addSmell($smell);
                $smell->addTastingSheet($tastingSheet2);
            }
            foreach ($selectedTastes as $taste) {
                $tastingSheet2->addTaste($taste);
                $taste->addTastingSheet($tastingSheet2);
            }

            $tastingSheetRepository->save($tastingSheet2, true);
        }

        if ($form3->isSubmitted() && $form3->isValid()) {
            // Traitez les données du formulaire

            $tastingSheet3->setWorkshop($workshop);

            $selectedSmells = $form3->get('smell')->getData();
            $selectedTastes = $form3->get('taste')->getData();

            foreach ($selectedSmells as $smell) {
                $tastingSheet3->addSmell($smell);
                $smell->addTastingSheet($tastingSheet3);
            }
            foreach ($selectedTastes as $taste) {
                $tastingSheet3->addTaste($taste);
                $taste->addTastingSheet($tastingSheet3);
            }

            $tastingSheetRepository->save($tastingSheet3, true);
        }

        if ($form4->isSubmitted() && $form4->isValid()) {
            // Traitez les données du formulaire

            $tastingSheet4->setWorkshop($workshop);

            $selectedSmells = $form4->get('smell')->getData();
            $selectedTastes = $form4->get('taste')->getData();

            foreach ($selectedSmells as $smell) {
                $tastingSheet4->addSmell($smell);
                $smell->addTastingSheet($tastingSheet4);
            }
            foreach ($selectedTastes as $taste) {
                $tastingSheet4->addTaste($taste);
                $taste->addTastingSheet($tastingSheet4);
            }

            $tastingSheetRepository->save($tastingSheet4, true);
        }


        return $this->render('tasting_sheet/index.html.twig', [
            'forms' => $forms,
            'tastingSheets' => $tastingSheets,
            'workshop' => $workshop,
        ]);
    }
}
