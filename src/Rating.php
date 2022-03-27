<?php

namespace Wulfheart\EloMMR;

class Rating
{
    public function __construct(
        public float $mu,
        public float $sig
    ) {
    }


    public function withNoise(float $sigNoise): Rating
    {
        return new Rating(
            $this->mu,
            sqrt($this->sig ** 2 + $sigNoise ** 2)
        );
    }
}