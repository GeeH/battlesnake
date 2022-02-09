<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;

class StartEndHandler implements RequestHandlerInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->logger->info('Start/End handler dispatched');
        $response = new Response();
        $response->getBody()->write(
            json_encode([
                'apiVersion' => '1',
                'author' => 'GeeH',
                'color' => '#FF0000',
                'head' => 'safe',
                'tail' => 'freckled',
                'version' => 'pre-alpha',
            ])
        );
        return $response;
    }
}
