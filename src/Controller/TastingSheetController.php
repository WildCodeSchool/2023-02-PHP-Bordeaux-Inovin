<?php

namespace App\Controller;

use App\Entity\Workshop;
use App\Entity\TastingSheet;
use App\Form\TastingSheetType1;
use App\Form\TastingSheetType2;
use App\Form\TastingSheetType3;
use App\Form\TastingSheetType4;
use App\Repository\TastingSheetRepository;
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
        SessionInterface $session
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

                $selectedSmellsArray = $selectedSmells->toArray();

                array_map(function ($smell) use ($tastingSheet) {
                    $tastingSheet->addSmell($smell);
                    $smell->addTastingSheet($tastingSheet);
                }, $selectedSmellsArray);

                $selectedTastesArray = $selectedTastes->toArray();

                array_map(function ($taste) use ($tastingSheet) {
                    $tastingSheet->addTaste($taste);
                    $taste->addTastingSheet($tastingSheet);
                }, $selectedTastesArray);

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
    public function addPercent(TastingSheetRepository $tastingSheetRepo, Workshop $workshop): Response
    {
        $tastingSheets = $tastingSheetRepo->findBy(['workshop' => $workshop, 'user' => $this->getUser()]);

        $cepageScoreArray = array_reduce($tastingSheets, function ($carry, $value) {
            $carry[$value->getWine()->getCepage()->getNameCepage()] = $value->getScoreTastingSheet();
            return $carry;
        }, []);

        $minimumScore = min($cepageScoreArray);
        $randomLowScoreCepage = array_rand(array_keys($cepageScoreArray, $minimumScore));
        $cepageScoreArray[$randomLowScoreCepage] = 0;

        $addAllScores = array_sum($cepageScoreArray);
        $percentTransformer = 100 / $addAllScores;
        $cepagePercentArray = array_map(function ($value) use ($percentTransformer) {
            return round($value * $percentTransformer);
        }, $cepageScoreArray);

        $sumOfPercent = array_sum($cepagePercentArray);
        $missingValue = 100 - $sumOfPercent;
        if ($missingValue > 0) {
            $randomHighScoreCepag = array_rand(array_keys($cepagePercentArray, max($cepagePercentArray)));
            $cepagePercentArray[$randomHighScoreCepag] += 1;
        }

        array_walk($tastingSheets, function ($tastingSheet) use ($cepagePercentArray, $tastingSheetRepo) {
            $cepageName = $tastingSheet->getWine()->getCepage()->getNameCepage();
            if (isset($cepagePercentArray[$cepageName])) {
                $tastingSheet->setPercentageTastingSheet($cepagePercentArray[$cepageName]);
                $tastingSheetRepo->save($tastingSheet, true);
            }
        });

        return $this->redirectToRoute('app_wine_blend_new');
    }
}
