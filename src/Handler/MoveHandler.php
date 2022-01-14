<?php

declare(strict_types=1);

namespace App\Handler;

use App\Factory\MoveFactory;
use App\Model\Move;
use App\Model\Point;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;

class MoveHandler implements RequestHandlerInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->logger->info('Move handler dispatched');
        $move = MoveFactory::create($request->getBody()->getContents());

        $instruction = $this->figureOutMove($move);

        $response = new Response();
        $response->getBody()->write(
            json_encode([
                'move' => $instruction,
                'shout' => $instruction,
            ])
        );
        return $response;
    }

    /**
     * @todo this can infinite loop - make it so it can't
     */
    public function figureOutMove(Move $move, string $proposedInstruction = null): string
    {
        if (empty($move->board->food)) {
            $proposedInstruction ??= $move->you->shout ?: 'up';

            if ($this->canMoveToProposedSpace($proposedInstruction, $move)) {
                return $proposedInstruction;
            }

            $proposedInstruction = match ($proposedInstruction) {
                'up' => 'right',
                'right' => 'down',
                'down' => 'left',
                'left' => 'up',
            };

            return $this->figureOutMove($move, $proposedInstruction);
        }

        return $this->figureOutMoveToFood($move);
    }

    private function canMoveToProposedSpace(string $proposedMove, Move $move): bool
    {
        // felisbinarius: $snakesHead = new Point( Match...., Match ...)
        if ($proposedMove === 'up') {
            $snakesHead = new Point($move->you->head->x, $move->you->head->y + 1);
        }

        if ($proposedMove === 'right') {
            $snakesHead = new Point($move->you->head->x + 1, $move->you->head->y);
        }

        if ($proposedMove === 'down') {
            $snakesHead = new Point($move->you->head->x, $move->you->head->y - 1);
        }

        if ($proposedMove === 'left') {
            $snakesHead = new Point($move->you->head->x - 1, $move->you->head->y);
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
                if ($snakesHead == $point) {
                    return false;
                }
            }
        }

        return true;
    }

    private function figureOutMoveToFood(Move $move): string
    {
        $food = $move->board->food[0];
        $distanceOnX = $food->x - $move->you->head->x;
        $distanceOnY = $food->y - $move->you->head->y;

        if ($distanceOnX !== 0) {
            return ($distanceOnX > 0) ? 'right' : 'left';
        }

        return ($distanceOnY > 0) ? 'up' : 'down';
    }
}
