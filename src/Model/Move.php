<?php

declare(strict_types=1);

namespace App\Model;

class Move
{
    public function __construct(
        public readonly Game $game,
        public readonly int $turn,
        public readonly Board $board,
        public readonly Snake $you,
    ) {
    }
}
