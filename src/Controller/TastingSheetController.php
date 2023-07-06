<?php

namespace App\Controller;

use App\Entity\Workshop;
use App\Entity\TastingSheet;
use App\Form\TastingSheetType1;
use App\Form\TastingSheetType2;
use App\Form\TastingSheetType3;
use App\Form\TastingSheetType4;
use App\Repository\TastingSheetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TastingSheetController extends AbstractController
{
    #[Route('/tastingSheet/{codeWorkshop}', name: 'app_tasting_sheet', methods: ['GET', 'POST'])]
    public function index(
        Workshop $workshop,
        Request $request,
        TastingSheetRepository $tastingSheetRepo,
        SessionInterface $session,
        EntityManagerInterface $entityManager
    ): Response {

        $tastingSheets = [];
        $forms = [];
        $tastingSheet = new TastingSheet();

        $formTypes = [
            $this->createForm(TastingSheetType1::class, $tastingSheet),
            $this->createForm(TastingSheetType2::class, $tastingSheet),
            $this->createForm(TastingSheetType3::class, $tastingSheet),
            $this->createForm(TastingSheetType4::class, $tastingSheet)
        ];
        $wineExist = $entityManager
            ->getRepository(TastingSheet::class)
            ->findOneBy(['wine' => $tastingSheet->getWine()]);
        if ($wineExist) {
            $this->addFlash('danger', "ce vin a déjà été dégusté.");
        }
        foreach ($formTypes as $form) {
            $form->handleRequest($request);
            $tastingSheets[] = $tastingSheet;
            $forms[] = $form->createView();

            if ($form->isSubmitted() && $form->isValid()) {

                // Traitez les données du formulaire
                $tastingSheet->setWorkshop($workshop);
                $tastingSheet->setUser($this->getUser());
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
                $tastingSheetRepo->save($tastingSheet, true);

                if ($session->has('countValidateForm')) {
                    $count = $session->get('countValidateForm');
                    $session->set('countValidateForm', $count + 1);
                } else {
                    $session->set('countValidateForm', 1);
                }
            }
            $countValidateForm = $session->get('countValidateForm');
        }

        return $this->render('tasting_sheet/index.html.twig', [
            'forms' => $forms,
            'tastingSheets' => $tastingSheets,
            'workshop' => $workshop,
            'countValidateForm' => $countValidateForm
        ]);
    }

    #[Route('/tastingSheet/show/{id}', name: 'tasting_sheet_show', methods: ['GET'])]
    public function show(
        TastingSheet $tastingSheet,
        TastingSheetRepository $tastingSheetRepo,
        int $id
    ): Response {

        $userTastingSheets = $tastingSheetRepo->findBy(['user' => $id]);
        return $this->render('tasting_sheet/show.html.twig', [
            'tasting_sheet' => $tastingSheet,
            'userTastingSheets' => $userTastingSheets,
        ]);
    }

    //en test
    #[Route('/tastingSheet/{codeWorkshop}/addPercent', name: 'tasting_sheet_addPercent', methods: ['GET', 'POST'])]
    public function addPercent(
        TastingSheetRepository $tastingSheetRepo,
        Workshop $workshop,
    ): Response {
        // get the tasting sheets from the workshop by user
        $workshop->getId();
        $tastingSheets = $tastingSheetRepo->findBy(['workshop' => $workshop, 'user' => $this->getUser()]);

        // create an array with the cepages and their scores/10 (by user/workshop)
        $cepageScoreArray = [];
        foreach ($tastingSheets as $key => $value) {
            $key = $value->getWine()->getCepage()->getNameCepage();
            $value = $value->getScoreTastingSheet();
            $cepageScoreArray[$key] = $value;
        }

        // identify the lowest score, and set it to 0.
        // If several cepages have the same lowest score, pick one randomly to set to 0
        $minimumScore = min(array_values($cepageScoreArray));
        $minimumScoreCepages = array_keys($cepageScoreArray, $minimumScore);
        $randomLowScoreCepage = $minimumScoreCepages[array_rand($minimumScoreCepages)];
        $cepageScoreArray[$randomLowScoreCepage] = 0;

        // transform the scores into percentages, so that they add up to 100
        $addAllScores = array_sum($cepageScoreArray);
        $percentTransformer = 100 / $addAllScores;
        $cepagePercentArray = [];
        foreach ($cepageScoreArray as $key => $value) {
            $cepagePercentArray[$key] = round($value * $percentTransformer);
        }

        // if the sum of the percentages is not 100, add the missing value to the cepage with the highest score
        $sumOfPercent = array_sum($cepagePercentArray);
        $missingValue = 100 - $sumOfPercent;
        if ($missingValue > 0) {
            $highestScore = max($cepagePercentArray);
            $highestScoreCepages = array_keys($cepagePercentArray, $highestScore);
            $randomHighScoreCepag = $highestScoreCepages[array_rand($highestScoreCepages)];
            $cepagePercentArray[$randomHighScoreCepag] += 1;
        }

        // update the tasting sheets of the user with the new percentages
        foreach ($tastingSheets as $key => $tastingSheet) {
            $cepageName = $tastingSheet->getWine()->getCepage()->getNameCepage();
            if (isset($cepagePercentArray[$cepageName])) {
                $tastingSheet->setPercentageTastingSheet($cepagePercentArray[$cepageName]);
                $tastingSheetRepo->save($tastingSheet, true);
            }
        }
        return $this->redirectToRoute('app_wine_blend_new');
    }
}
