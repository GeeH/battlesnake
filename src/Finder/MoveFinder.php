<?php

declare(strict_types=1);

namespace App\Finder;

use App\Model\Config;
use App\Model\Move;
use App\Model\ProposedMove;

/** The Class Formerly Known as Crisps */
final class MoveFinder
{
    const UP = 'up';
    const RIGHT = 'right';
    const DOWN = 'down';
    const LEFT = 'left';

    public function __construct(
        private readonly Move $move,
        private readonly Config $config,
    ) {
    }

    public function figureOutMove(): string
    {
        $validMoves = [self::UP, self::RIGHT, self::DOWN, self::LEFT];

        // felisbinarius: $validMoves += array_map([$this, 'getMoveWeight'], $valueMoves);
        foreach ($validMoves as $direction) {
            $validMoves[$direction] = $this->getMoveWeight($direction);
        }

        return self::UP;
    }

    private function getMoveWeight(string $direction): ProposedMove
    {
        // felisbinarius: return array_sum([ $this->addWeightForFood($direction, new ProposedMove($direction)),  ]);
        $proposedMove = $this->addWeightForFood(new ProposedMove($direction));

        return $proposedMove;
    }

    private function addWeightForFood(ProposedMove $proposedMove): ProposedMove
    {
        if($this->move->you->health > $this->config->healthBeforeFindingFood) {
            // we need to consider how we adjust the weighting if there is food on the square
            // in this direction. Do we actively avoid food until we need it?
            // Do we gobble food if we're smaller than our opponent
            // For now, we don't have any answers to these interesting and well considered queries

            return $proposedMove;
        }


    }
}
