<?php

use function PHPUnit\Framework\assertSame;

test(
    'figures out the right way for a 🐍 to move',
    function (string $postedData, string $validResult, string $name) {

        $moveFinder = new \App\Finder\MoveFinder(
            \App\Factory\MoveFactory::create($postedData),
            new \App\Model\Config()
        );
        assertSame(
            $validResult,
            $moveFinder->figureOutMove(),
            $name,
        );
    }
)->with([
    [
        \file_get_contents(__DIR__.'/assets/mooocho-butter.json'),
        'right',
        'go-right-at-top-wall'
    ],
    [
        \file_get_contents(__DIR__.'/assets/board-1.json'),
        'right',
        'go-right-to-avoid-snakes'
    ],
//    [
//        \file_get_contents(__DIR__.'/assets/board-3.json'),
//        'up',
//        'board-3'
//    ],
//    [
//        \file_get_contents(__DIR__.'/assets/board-4.json'),
//        'left',
//        'board-4'
//    ],
//    [
//        \file_get_contents(__DIR__.'/assets/board-5.json'),
//        'right',
//        'board-5'
//    ],
//    [
//        \file_get_contents(__DIR__.'/assets/board-6.json'),
//        'up',
//        'board-6'
//    ],
//    [
//        \file_get_contents(__DIR__.'/assets/board-11.json'),
//        'right',
//        'board-11'
//    ],
//    [
//        \file_get_contents(__DIR__.'/assets/board-9.json'),
//        'down',
//        'board-9'
//    ],
]);

// @todo 28th Jan = Fix recursive loop when we're figuring out if a move is risky or not
// up = 50 (not wall, no food and we're not hungry, not turning into smaller than ourselves
// left = 0 (turning into wall)
// down = 25 (not wall, eating food)
