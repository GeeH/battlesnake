<?php

declare(strict_types=1);

namespace App\Model;

class Board
{
    /**
     * @param  Snake[]  $snakes
     * @param  Point[] $food
     * @param  Point[] $hazards
     */
    public function __construct(
        public readonly int $height,
        public readonly int $width,
        public readonly array $snakes,
        public readonly array $food,
        public readonly array $hazards,
    ) {
    }
}
