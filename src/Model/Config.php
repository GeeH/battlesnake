<?php

declare(strict_types=1);

namespace App\Model;

class Config
{
    public function __construct(
        public readonly int $healthBeforeFindingFood = 50,
        public readonly int $foodPriority = 1,
        public readonly int $middleOfTheBoardPriority = 1,
        public readonly int $canFitTheSnakePriority = 1,
        public readonly int $considerOtherSnakesPriority = 1,
    ) {
    }
}
