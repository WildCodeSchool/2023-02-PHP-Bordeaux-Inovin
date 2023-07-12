<?php

namespace App\Service;

use App\Entity\Vote;
use App\Entity\Workshop;
use App\Repository\VoteRepository;
use App\Repository\WineBlendRepository;

class CalculatorVote
{
    public function calculVote(
        VoteRepository      $voteRepository,
        Workshop            $workshop,
        WineBlendRepository $blendRepository
    ): void
    {
        $wineBlends = $blendRepository->findBy(['workshop' => $workshop]);

        foreach ($wineBlends as $wineBlend) {
            $votes = $voteRepository->findBy(['workshop' => $workshop, 'wineBlend' => $wineBlend]);

            $totalPoint = 0;
            $index = count($votes);

            foreach ($votes as $vote) {
                $point = $vote->getScoreVote();
                $totalPoint += $point;
            }

            $totalScore = $index > 0 ? $totalPoint / $index : 0;

            $wineBlend->setScoreWineBlend($totalScore);
            $blendRepository->save($wineBlend, true);
        }
    }
}
