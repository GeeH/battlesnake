<?php

declare(strict_types=1);

namespace App\Drama;

use App\Model\Move;
use App\Model\Point;

class Helpers
{
    public static function spacesAvailable(
        Move $move,
        Point $snakeHead,
        array &$checked = [],
    ): int {
        $checked[] = $snakeHead;

        $canMoveUp = self::isValidSpace($move, 'up', $snakeHead)
            && !in_array($snakeHead->moveUp(), $checked);
        if ($canMoveUp) {
            self::spacesAvailable($move, $snakeHead->moveUp(), $checked);
        }

        $canMoveRight = self::isValidSpace($move, 'right', $snakeHead)
            && !in_array($snakeHead->moveRight(), $checked);
        if ($canMoveRight) {
            self::spacesAvailable($move, $snakeHead->moveRight(), $checked);
        }

        $canMoveDown = self::isValidSpace($move, 'down', $snakeHead)
            && !in_array($snakeHead->moveDown(), $checked);
        if ($canMoveDown) {
            self::spacesAvailable($move, $snakeHead->moveDown(), $checked);
        }

        $canMoveLeft = self::isValidSpace($move, 'left', $snakeHead)
            && !in_array($snakeHead->moveLeft(), $checked);
        if ($canMoveLeft) {
            self::spacesAvailable($move, $snakeHead->moveLeft(), $checked);
        }

        return count($checked);
    }

    public static function isValidSpace(Move $move, string $proposedMove, ?Point $snakesHead = null): bool
    {
        $snakesHead ??= $move->you->head;

        if ($proposedMove === 'up') {
            $snakesHead = $snakesHead->moveUp();
        }

        if ($proposedMove === 'right') {
            $snakesHead = $snakesHead->moveRight();
        }

        if ($proposedMove === 'down') {
            $snakesHead = $snakesHead->moveDown();
        }

        if ($proposedMove === 'left') {
            $snakesHead = $snakesHead->moveLeft();
        }

        if (!$snakesHead) {
            return false;
        }

        /**
         * Check if we're trying to move off the edge of the board
         */
        if ($snakesHead->x < 0 || $snakesHead->y < 0) {
            return false;
        }
        if ($snakesHead->x === $move->board->width || $snakesHead->y === $move->board->height) {
            return false;
        }

        /**
         * Check we're not going to run into any other sneks
         */
        foreach ($move->board->snakes as $snake) {
            foreach ($snake->body as $point) {
                if ($snakesHead->equals($point)) {
                    return false;
                }
            }
        }

        return true;
    }
}
