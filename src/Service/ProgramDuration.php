<?php

namespace App\Service;

use App\Entity\Program;

class ProgramDuration
{
    public function calculate(Program $program): int
    {
        $total = 0;
        foreach ($program->getSeasons() as $seasons )
        {
            foreach ($seasons->getEpisodes() as $episodes)
            {
                $total += $episodes->getDuration();
            }
        }
        return $total;
    }
}