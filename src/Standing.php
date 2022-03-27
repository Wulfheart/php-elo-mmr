<?php

namespace Wulfheart\EloMMR;

class Standing
{
    public function __construct(
        public Player $player,
        public int $lowRank,
        public int $highRank
    )
    {
    }
}