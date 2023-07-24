<?php

namespace App\Controller;

use App\Entity\Gout;
use App\Form\GoutType;
use App\Repository\AromeRepository;
use App\Repository\ColorRepository;
use App\Repository\GoutRepository;
use App\Repository\RegionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/gout', name: 'gout_')]
class GoutController extends AbstractController
{
    /**
     * @param AromeRepository $aromeRepository
     * @param RegionRepository $regionRepository
     * @param ColorRepository $colorRepository
     * @return Response
     */
    #[Route('/', name: 'app_gout')]
    public function index(
        AromeRepository $aromeRepository,
        RegionRepository $regionRepository,
        ColorRepository $colorRepository
    ): Response {

        $arome = $aromeRepository->findAll();
        $region = $regionRepository->findAll();
        $color = $colorRepository->findAll();

        return $this->render('gout/index.html.twig', [
            'arome' => $arome,
            'region' => $region,
            'color' => $color
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, GoutRepository $goutRepository): Response
    {

        $gout = new Gout();
        $form = $this->createForm(GoutType::class, $gout);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $gout->setUser($this->getUser());
            $selectedColors = $form->get('color')->getData();
            $selectedAromes = $form->get('arome')->getData();
            $selectedRegions = $form->get('region')->getData();

            $selectedColorsArray = $selectedColors->toArray();

            array_map(function ($color) use ($gout) {
                $gout->addColor($color);
                $color->addGout($gout);
            }, $selectedColorsArray);


            $selectedAromesArray = $selectedAromes->toArray();

            array_map(function ($arome) use ($gout) {
                $gout->addArome($arome);
                $arome->addGout($gout);
            }, $selectedAromesArray);

            $selectedRegionsArray = $selectedRegions->toArray();

            array_map(function ($region) use ($gout) {
                $gout->addRegion($region);
                $region->addGout($gout);
            }, $selectedRegionsArray);

            $goutRepository->save($gout, true);

            return $this->redirectToRoute('app_atelier');
        }


        return $this->render('gout/new.html.twig', [
            'form' => $form->createView(), 'gout' => $gout,
        ]);
    }

    #[Route('/show', name: 'show')]
    public function show(GoutRepository $goutRepository, Request $request, SessionInterface $session): response
    {
        $roleUser = $this->getUser()->getRoles();

        if ('ROLE_ADMIN' == $roleUser[0]) {
            return $this->redirectToRoute('admin');
        }

        $session->set('countValidateForm', 0);
        $gout = $goutRepository->findOneBy(['user' => $this->getUser()]);

        if (!$gout) {
            return $this->redirectToRoute('gout_new');
        }

        $form = $this->createForm(GoutType::class, $gout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Supprimer les boucles foreach inutiles pour les relations ManyToMany (couleur, arôme, région)
            $goutRepository->save($gout, true);
            // ...

            return $this->redirectToRoute('gout_show');
        }

        return $this->render('gout/show.html.twig', [
            'gout' => $gout,
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, GoutRepository $goutRepository, Gout $gout): Response
    {
        if ($this->getUser() !== $gout->getUser()) {
            // If not the owner, throws a 403 Access Denied exception
            throw $this->createAccessDeniedException('Only the owner can edit your gout!');
        }

        $form = $this->createForm(GoutType::class, $gout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Supprimer les boucles foreach inutiles pour les relations ManyToMany (couleur, arôme, région)
            $goutRepository->save($gout, true);
            // ...

            return $this->redirectToRoute('app_atelier');
        }

        return $this->render('atelier/welcome.html.twig', [

            'form' => $form->createView(),
            'gout' => $gout,
        ]);
    }
}
