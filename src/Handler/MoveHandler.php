<?php

declare(strict_types=1);

namespace App\Handler;

use App\Drama\Helpers;
use App\Factory\MoveFactory;
use App\Model\Move;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;

class MoveHandler implements RequestHandlerInterface
{
    private LoggerInterface $logger;
    private array $availableMoves = ['up', 'right', 'down', 'left'];
    private array $riskMoves = [];

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

    public function figureOutMove(Move $move): string
    {
        if (empty($move->board->food) || $move->you->health > 50) {
            return $this->holdingPattern($move);
        }

        return $this->figureOutMoveToFood($move);
    }

    public function holdingPattern(Move $move): string
    {
        if (empty($this->availableMoves)) {
            if (!empty($this->riskMoves)) {
                return array_shift($this->riskMoves);
            }
            throw new NoMovesAvailableException('NO MOVES');
        }


        $proposedInstruction = array_shift($this->availableMoves);
        $methodName = 'move'.ucfirst($proposedInstruction);

        $snakeLength = $move->you->length;


        // if we didn't eat this turn, it's safe to discount our tail from the snakes total length
        // felisbinarius: if (! $move->you->body[count($move->you->body)]->equals($move->you->body[count($move->you->body) -2]
        // felisbinarius: $move->you->body[index]->equals($otherPoint)
        if ($move->you->body[count($move->you->body) - 1] != $move->you->body[count($move->you->body) - 2]) {
            $snakeLength--;
        }

        $isRiskyMove = $snakeLength >= Helpers::spacesAvailable($move, $move->you->head->{$methodName}());

        if (
            Helpers::isValidSpace($move, $proposedInstruction)
        ) {
            if (!$isRiskyMove) {
                return $proposedInstruction;
            }
            $this->riskMoves[] = $proposedInstruction;
        }

        return $this->holdingPattern($move);
    }

    /**
     * @throws NoMovesAvailableException
     */
    private function figureOutMoveToFood(Move $move, int $foodIndex = 0): string
    {
        /**
         * We can't get to any food, do a holding pattern move for this turn
         */
        if ($foodIndex === count($move->board->food)) {
            return $this->holdingPattern($move);
        }

        $food = $move->board->food[$foodIndex];

        $distanceOnX = $food->x - $move->you->head->x;
        $distanceOnY = $food->y - $move->you->head->y;

        $proposedMove = ($distanceOnY > 0) ? 'up' : 'down';

        if ($distanceOnX !== 0) {
            $proposedMove = ($distanceOnX > 0) ? 'right' : 'left';
        }

        if (Helpers::isValidSpace($move, $proposedMove)) {
            return $proposedMove;
        }

        return $this->figureOutMoveToFood($move, $foodIndex + 1);
    }
}
