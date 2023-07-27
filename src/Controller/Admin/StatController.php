<?php

namespace App\Controller\Admin;

use App\Repository\AromeRepository;
use App\Repository\ColorRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatController extends AbstractController
{
    #[Route('/admin/stat', name: 'app_admin_stat')]
    public function statGout(
        ColorRepository $colorRepository,
        AromeRepository $aromeRepository,
        RegionRepository $regionRepository
    ): Response {

        $colors = $colorRepository->findAll();
        $colorName = [];
        $countColor = [];
        $colorsTab = [];


        foreach ($colors as $color) {
            $colorName[] = $color->getNameColor();
            $countColor[] = $color->getGouts()->count();
            $colorNameTwig = $color->getNameColor();
            $countColorTwig = $color->getGouts()->count();
            $colorsTab[$colorNameTwig] = $countColorTwig;
        }

        $aromes = $aromeRepository->findAll();
        $aromeName = [];
        $countArome = [];
        $aromesTab = [];

        foreach ($aromes as $arome) {
            $aromeName[] = $arome->getNameArome();
            $countArome[] = $arome->getGouts()->count();
            $aromeNameTwig = $arome->getNameArome();
            $countAromeTwig = $arome->getGouts()->count();
            $aromesTab[$aromeNameTwig] = $countAromeTwig;
        }

        $regions = $regionRepository->findAll();
        $regionName = [];
        $countRegion = [];
        $regionsTab = [];

        foreach ($regions as $region) {
            $regionName[] = $region->getNameRegion();
            $countRegion[] = $region->getGouts()->count();
            $regionNameTwig = $region->getNameRegion();
            $countRegionTwig = $region->getGouts()->count();
            $regionsTab[$regionNameTwig] = $countRegionTwig;
        }

        return $this->render('admin/stat.html.twig', [
            'colors' => $colorsTab,
            'aromes' => $aromesTab,
            'regions' => $regionsTab,

            'colorName' => json_encode($colorName),
            'goutColorCount' => json_encode($countColor),
            'aromeName' => json_encode($aromeName),
            'goutAromeCount' => json_encode($countArome),
            'regionName' => json_encode($regionName),
            'goutRegionCount' => json_encode($countRegion),

        ]);
    }
}
