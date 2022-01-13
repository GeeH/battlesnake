<?php

declare(strict_types=1);

namespace App\Handler;

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

        $postedData = json_decode((string)$request->getBody(), true);

        $move = $this->figureOutMove($postedData['you']['shout'], $postedData['you']['body']);

        $response = new Response();
        $response->getBody()->write(
            json_encode([
                            'move' => $move,
                            'shout' => $move,
                        ])
        );
        return $response;
    }

    public function figureOutMove(string $lastMove, array $snakePositions): string
    {
        $head = $snakePositions[0];

        if ($lastMove === '' || $lastMove === 'left') {
            $head['y']++;
            foreach ($snakePositions as $position) {
                if ($position === $head) {
                    return $lastMove;
                }
            }
            return 'up';
        }

        if ($lastMove === 'up') {
            $head['x']++;
            foreach ($snakePositions as $position) {
                if ($position === $head) {
                    return $lastMove;
                }
            }
            return 'right';
        }

        if ($lastMove === 'right') {
            $head['y']--;
            foreach ($snakePositions as $position) {
                if ($position === $head) {
                    return $lastMove;
                }
            }
            return 'down';
        }

        if ($lastMove === 'down') {
            $head['x']--;
            foreach ($snakePositions as $position) {
                if ($position === $head) {
                    return $lastMove;
                }
            }
            return 'left';
        }
    }
}
