<?php

namespace App\Controller;

use App\Entity\User;
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
        $formsValidated = [];
        $tastingSheet = new TastingSheet();

        $formTypes = [
            $this->createForm(TastingSheetType1::class, $tastingSheet),
            $this->createForm(TastingSheetType2::class, $tastingSheet),
            $this->createForm(TastingSheetType3::class, $tastingSheet),
            $this->createForm(TastingSheetType4::class, $tastingSheet)
        ];

        foreach ($formTypes as $key => $form) {
            $form->handleRequest($request);
            $tastingSheets[] = $tastingSheet;
            $forms[] = $form->createView();

            if ($form->isSubmitted()) {
                // Traitez les données du formulaire
                $tastingSheet->setWorkshop($workshop);
                $tastingSheet->setUser($this->getUser());
                $selectedSmells = $form->get('smell')->getData();
                $selectedTastes = $form->get('taste')->getData();

                $cepage = $form->get('wine')->getData()->getCepage();
                if ($session->has('countValidateForm')) {
                    $count = $session->get('countValidateForm');
                    $session->set('countValidateForm', $count + 1);
                } else {
                    $session->set('countValidateForm', 1);
                }
                if ($session->has('keysValidateForms')) {
                    $keys = $session->get('keysValidateForms');
                    $keys[] = $key;
                    $session->set('keysValidateForms', $keys);
                } else {
                    $session->set('keysValidateForms', [$key]);
                }
                if ($form->get('scoreTastingSheet')->getData() === null) {
                    $this->addFlash(
                        'danger',
                        "Vous devez renseigner une note pour le cépage -
                        -$cepage--> cette fiche de dégustation n'a pas été enregistrée"
                    );
                    if ($session->has('countValidateForm')) {
                        $count = $session->get('countValidateForm');
                        $session->set('countValidateForm', $count - 1);
                    }
                }

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
            }

            $countValidateForm = $session->get('countValidateForm');
            $formsValidated = $session->get('keysValidateForms');
        }

        return $this->render('tasting_sheet/index.html.twig', [
            'forms' => $forms,
            'tastingSheets' => $tastingSheets,
            'workshop' => $workshop,
            'countValidateForm' => $countValidateForm,
            'formsValidated' => $formsValidated,
        ]);
    }

    #[Route('/tasting-sheet/show/{id}', name: 'tasting_sheet_show', methods: ['GET'])]
    public function show(
        TastingSheetRepository $tastingSheetRepo,
        User $user,
    ): Response {

        $id = $this->getUser();
        $tastingSheets = $tastingSheetRepo->findBy(['id' => $id]);
        return $this->render('tasting_sheet/show.html.twig', [
            'tasting_sheets' => $tastingSheets,
            'user' => $user,
        ]);
    }

    //en test
    #[Route('/tastingSheet/{codeWorkshop}/addPercent', name: 'tasting_sheet_addPercent', methods: ['GET', 'POST'])]
    public function addPercent(TastingSheetRepository $tastingSheetRepo, Workshop $workshop): Response
    {
        $tastingSheets = $tastingSheetRepo->findBy(['workshop' => $workshop, 'user' => $this->getUser()]);

        // create an array with the cepages and their scores/10 (by user/workshop)
        $cepageScoreArray = array_reduce($tastingSheets, function ($carry, $value) {
            $carry[$value->getWine()->getCepage()->getNameCepage()] = $value->getScoreTastingSheet();
            return $carry;
        }, []);


        // identify the lowest score, and set it to 0.
        // If several cepages have the same lowest score, pick one randomly to set to 0
        $minimumScore = min(array_values($cepageScoreArray));
        $minimumScoreCepages = array_keys($cepageScoreArray, $minimumScore);
        $randomLowScoreCepage = $minimumScoreCepages[array_rand($minimumScoreCepages)];
        $cepageScoreArray[$randomLowScoreCepage] = 0;


        // transform the scores into percentages, so that they add up to 100
        $addAllScores = array_sum($cepageScoreArray);
        $percentTransformer = 100 / $addAllScores;
        $cepagePercentArray = array_map(function ($value) use ($percentTransformer) {
            return round($value * $percentTransformer);
        }, $cepageScoreArray);

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
        array_walk($tastingSheets, function ($tastingSheet) use ($cepagePercentArray, $tastingSheetRepo) {
            $cepageName = $tastingSheet->getWine()->getCepage()->getNameCepage();
            if (isset($cepagePercentArray[$cepageName])) {
                $tastingSheet->setPercentTastingSheet($cepagePercentArray[$cepageName]);
                $tastingSheetRepo->save($tastingSheet, true);
            }
        });

        return $this->redirectToRoute('app_wine_blend_new', ['codeWorkshop' => $workshop->getCodeWorkshop()]);
    }
}
