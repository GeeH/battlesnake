<?php

declare(strict_types=1);

namespace App\Model;

class ProposedMove
{
    public function __construct(
        public string $direction,
        public Point $newHeadPoint,
        public int $weight = 0,
        public int $food = 0,
        public int $middle = 0,
        public int $aggression = 0,
        public int $cowardice = 0,
    ) {
    }
}
