<?php

declare(strict_types=1);

namespace App\Model;

class Move implements \Stringable
{
    public function __construct(
        public readonly Game $game,
        public readonly int $turn,
        public readonly Board $board,
        public readonly Snake $you,
    ) {
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    public function toArray(): array
    {
        $move = (array)$this;
        $move['board'] = $this->board->toArray();
        return $move;
    }
}
