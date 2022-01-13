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

        $move = $this->figureOutMove($postedData);

        $response = new Response();
        $response->getBody()->write(
            json_encode([
                            'move' => $move,
                            'shout' => $move,
                        ])
        );
        return $response;
    }

    public function figureOutMove(array $postedData, string $proposedMove = null): string
    {
        if(empty($proposedMove)) {
            $proposedMove = $postedData['you']['shout'] !== '' ? $postedData['you']['shout'] : 'up';
        }

        if ($this->canMoveToProposedSpace($proposedMove, $postedData)) {
            return $proposedMove;
        }

        $proposedMove = match($proposedMove) {
            'up' => 'right',
            'right' => 'down',
            'down' => 'left',
            'left' => 'up',
        };

        return $this->figureOutMove($postedData, $proposedMove);
    }

    private function canMoveToProposedSpace(string $proposedMove, array $postedData): bool
    {
        $snakesHead = $postedData['you']['head'];
        if ($proposedMove === 'up') {
            $snakesHead['y']++;
        }
        if ($proposedMove === 'right') {
            $snakesHead['x']++;
        }
        if ($proposedMove === 'down') {
            $snakesHead['y']--;
        }
        if ($proposedMove === 'left') {
            $snakesHead['x']--;
        }

        if ($snakesHead['x'] < 0 || $snakesHead['y'] < 0) {
            return false;
        }

        if ($snakesHead['x'] === $postedData['board']['width'] || $snakesHead['y'] === $postedData['board']['height']) {
            return false;
        }

        foreach ($postedData['board']['snakes'] as $snake) {
            foreach ($snake['body'] as $body) {
                if($snakesHead === $body) {
                    return false;
                }
            }
        }

        return true;
    }
}
