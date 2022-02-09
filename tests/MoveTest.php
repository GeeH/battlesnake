<?php

use function PHPUnit\Framework\assertSame;

test(
    'figures out the right way for a 🐍 to move',
    function (string $postedData, string $validResult, string $name) {
        $logger = new \Monolog\Logger('test');
        $moveHandler = new \App\Handler\MoveHandler($logger);

        $move = \App\Factory\MoveFactory::create($postedData);
        assertSame(
            $validResult,
            $moveHandler->figureOutMove($move),
            $name,
        );
    }
)->with([
    [
        \file_get_contents(__DIR__.'/assets/board-1.json'),
        'right',
        'board-1'
    ],
    [
        \file_get_contents(__DIR__.'/assets/board-2.json'),
        'down',
        'board-2'
    ],
    [
        \file_get_contents(__DIR__.'/assets/board-3.json'),
        'up',
        'board-3'
    ],
    [
        \file_get_contents(__DIR__.'/assets/board-4.json'),
        'left',
        'board-4'
    ],
    [
        \file_get_contents(__DIR__.'/assets/board-5.json'),
        'right',
        'board-5'
    ],
    [
        \file_get_contents(__DIR__.'/assets/board-6.json'),
        'up',
        'board-6'
    ],
    [
        \file_get_contents(__DIR__.'/assets/board-11.json'),
        'right',
        'board-11'
    ],
    [
        \file_get_contents(__DIR__.'/assets/board-9.json'),
        'down',
        'board-9'
    ],
]);

// @todo 28th Jan = Fix recursive loop when we're figuring out if a move is risky or not
// up = 50 (not wall, no food and we're not hungry, not turning into smaller than ourselves
// left = 0 (turning into wall)
// down = 25 (not wall, eating food)
