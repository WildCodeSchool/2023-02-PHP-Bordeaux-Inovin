<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Smell;
use App\Entity\Workshop;
use App\Entity\TastingSheet;
use App\Form\CommentType;
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
    public function index(
        Workshop $workshop,
        Request $request,
        WorkshopRepository $workshopRepository,
        TastingSheetRepository $tastingSheetRepository
    ): Response {
     // $comment = new Comment();
     //   $formComment = $this->createForm(CommentType::class, $comment);
     //   $formComment->handleRequest($request);

        $tastingSheet = new TastingSheet();
        $form = $this->createForm(TastingSheetType::class, $tastingSheet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
         //   $tastingSheet->setComment($comment);
            //$tastingSheet->setUser($this->getUser());
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
            $tastingSheet->setWorkshop($workshop);


           // $commentRepository->save($comment, true);
            $tastingSheetRepository->save($tastingSheet, true);

            // return $this->redirectToRoute('gout_edit', ['id' => $tastingSheet->getId()]);
        }

        return $this->render('tasting_sheet/index.html.twig', [
            'form' => $form->createView(),
            'tastingSheet' => $tastingSheet,
         //  'formComment' => $formComment->createView(),
         //  'comment' => $comment,
        ]);
    }
}
