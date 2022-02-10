<?php

declare(strict_types=1);

namespace App\Handler;

use App\Factory\MoveFactory;
use App\Finder\MoveFinder;
use App\Model\Config;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;

class MoveHandler implements RequestHandlerInterface
{
    public function __construct(
        private LoggerInterface $logger,
    )
    {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $move = MoveFactory::create($request->getBody()->getContents());
        $this->logger->info('Move handler dispatched: '.$move);

        $finder = new MoveFinder($move, new Config());
        $instruction = $finder->figureOutMove();

        $response = new Response();
        $responseJson = json_encode([
            'move' => $instruction,
            'shout' => $instruction,
        ]);
        $response->getBody()->write(
            $responseJson
        );

        $this->logger->info('Response: '.$responseJson);
        return $response;
    }
}
