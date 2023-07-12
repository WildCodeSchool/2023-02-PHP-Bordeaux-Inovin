<?php

namespace App\Controller;

use App\Form\WorkshopCodeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AtelierController extends AbstractController
{
    #[Route('/atelier', name: 'app_atelier')]
    public function index(Request $request, SessionInterface $session,): Response
    {
        $workshopCodeForm = $this->createForm(WorkshopCodeType::class);
        $workshopCodeForm->handleRequest($request);
        if ($workshopCodeForm->isSubmitted()/* && $form->isValid()*/) {
            $code = $workshopCodeForm->get('codeWorkshop')->getData();
            if ($session->has('countValidateForm')) {
                $session->set('countValidateForm', 0);
            }
            return $this->redirectToRoute('app_tasting_sheet', ['codeWorkshop' => $code]);
        }
        return $this->render(
            'atelier/welcome.html.twig',
            [
                'workshopCodeForm' => $workshopCodeForm,
            ]
        );
    }
}
