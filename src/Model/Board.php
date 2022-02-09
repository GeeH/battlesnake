<?php

declare(strict_types=1);

namespace App\Model;

class Board
{
    /**
     * @param  Snake[]  $snakes
     * @param  Point[]  $food
     * @param  Point[]  $hazards
     */
    public function __construct(
        public readonly int $height,
        public readonly int $width,
        public readonly array $snakes,
        public readonly array $food,
        public readonly array $hazards,
    ) {
    }

    public function toArray(): array
    {
        $board = (array)$this;

        foreach ($board['snakes'] as $index => $snake) {
            $snake = (array)$snake;
            foreach ($snake['body'] as $i => $point) {
                $snake['body'][$i] = [$point->x, $point->y];
            }
            $snake['head'] = [$snake['head']->x, $snake['head']->y];
            $snake['customizations'] = (array)$snake['customizations'];
            $board['snakes'][$index] = $snake;
        }

        return $board;
    }
}
