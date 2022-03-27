<?php

namespace Wulfheart\EloMMR;

class EloMMRRating
{
    public function __construct(
        // beta must exceed sig_limit
        // squared variation in individual performances, when the contest_weight is 1
        public float $beta = 200,
        // each contest participation adds an amount of drift such that, in the absence of
        // much time passing, the limiting skill uncertainty's square approaches this value
        public float $sigLimit = 80,
        // additional variance per second, from a drift that's continuous in time
        public float $driftPerSecond = 0,
        // maximum number of opponents and recent events to use, as a compute-saving approximation
        public float $transferSpeed = 1,
    ) {
    }

    /**
     * @param  iterable<\Wulfheart\EloMMR\Standing>  $standings
     * @return void
     */
    public function roundUpdate(float $contestWeight, iterable $standings)
    {
        $standings = collect($standings);

        $excessBetaSq = ($this->beta ** 2 - $this->sigLimit ** 2) / $contestWeight;
        $sigPerf = sqrt($this->sigLimit ** 2 + $excessBetaSq);
        $discreteDrift = ($this->sigLimit ** 4) / $excessBetaSq;

        $tanhTerms = $standings->map(function (Standing $standing) use ($sigPerf, $discreteDrift) {
            $continuousDrift = $this->driftPerSecond * $standing->player->updateTime;

            $sigDrift = sqrt($discreteDrift + $continuousDrift);
        });
    }

}
