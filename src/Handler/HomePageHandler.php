<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;

class HomePageHandler implements RequestHandlerInterface
{
    private LoggerInterface $logger;
    private array $snek;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->snek = [
            'apiversion' => '1',
            'author' => 'GeeH',
            'color' => '#FF0000',
            'head' => 'safe',
            'tail' => 'freckled',
            'version' => 'v3-final',
        ];
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->logger->info('Home page handler dispatched');
        $response = new Response();
        $response = $response->withAddedHeader('content-type', 'application/json');
        $response->getBody()->write(json_encode($this->snek));
        return $response;
    }
}
