<?php

declare(strict_types=1);

use App\Handler;
use Slim\App;

return function (App $app) {
    $app->get('/', Handler\HomePageHandler::class)->setName('home');
    $app->post('/start', Handler\StartEndHandler::class)->setName('start');
    $app->post('/end', Handler\StartEndHandler::class)->setName('end');
    $app->post('/move', Handler\MoveHandler::class)->setName('move');
};
