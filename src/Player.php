<?php

namespace Wulfheart\EloMMR;

class Player
{
    /** @var array<\Wulfheart\EloMMR\PlayerEvent> */
    public array $eventHistory;
    public Rating $approxPosterior;
    public int $updateTime;
    public int $deltaTime;

    protected Rating $normalFactor;
    /** @var array<\Wulfheart\EloMMR\TanhTerm> */
    protected array $logisticFactors;

    public function addNoiseBest(float $sigNoise, float $transferSpeed): void
    {
        $newPosterior = $this->approxPosterior->withNoise($sigNoise);
    }
}
