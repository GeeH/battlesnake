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

    // - We're hungry and there is food on this square +100
    // - We're hungry and there's food in this direction? +50

    public function figureOutMove(): string
    {
        $validMoves = [self::UP, self::RIGHT, self::DOWN, self::LEFT];
        $weightedMoves = [];
        // felisbinarius: $validMoves += array_map([$this, 'getMoveWeight'], $valueMoves);
        foreach ($validMoves as $direction) {
            $weightedMoves[] = $this->getMoveWeight($direction);
        }

        usort($weightedMoves, static function (ProposedMove $move1, ProposedMove $move2): int {
            return $move2->weight <=> $move1->weight;
        });

        $bestMove =  array_shift($weightedMoves);
        return $bestMove->direction;

    }

    private function getMoveWeight(string $direction): ProposedMove
    {
        // felisbinarius: return array_sum([ $this->addWeightForFood($direction, new ProposedMove($direction)),  ]);
        // if the space in this direction has food in it, add the weight otherwise don't
        //        $proposedMove = $this->addWeightForFood(new ProposedMove($direction));
        $moveDirectionMethod = 'move'.ucfirst($direction);
        $proposedMove = new ProposedMove(
            $direction,
            $this->move->you->head->{$moveDirectionMethod}()
        );


        if ($this->collidesWithWall($proposedMove) || $this->collidesWithSnake($proposedMove)) {
            $proposedMove->weight = -1;
            return $proposedMove;
        }


        return $proposedMove;
    }

    private function collidesWithWall(ProposedMove $proposedMove): bool
    {
        /**
         * Check if we're trying to move off the edge of the board
         */
        if ($proposedMove->newHeadPoint->x < 0 || $proposedMove->newHeadPoint->y < 0) {
            return true;
        }
        if ($proposedMove->newHeadPoint->x === $this->move->board->width
            || $proposedMove->newHeadPoint->y === $this->move->board->height) {
            return true;
        }
        return false;
    }

    private function addWeightForFood(ProposedMove $proposedMove): ProposedMove
    {
        if ($this->move->you->health > $this->config->healthBeforeFindingFood) {
            // we need to consider how we adjust the weighting if there is food on the square
            // in this direction. Do we actively avoid food until we need it?
            // Do we gobble food if we're smaller than our opponent
            // For now, we don't have any answers to these interesting and well considered queries

            return $proposedMove;
        }

        // moveUp etc
        // felisbinarius: lets move this move method generation to a move method on the point class

        foreach ($this->move->board->food as $foodPoint) {
            if ($newHeadPoint->equals($foodPoint)) {
                $proposedMove->food = 100;
                $proposedMove->weight += 100 * $this->config->foodPriority;
            }
        }

        return $proposedMove;
    }

    private function collidesWithSnake(ProposedMove $proposedMove): bool
    {
        foreach ($this->move->board->snakes as $snake) {
            foreach ($snake->body as $point) {
                if ($proposedMove->newHeadPoint->equals($point)) {
                    return true;
                }
            }
        }
        return false;
    }

}
