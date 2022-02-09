<?php

use App\Model\Point;

test('it can return number of squares that are empty', function (string $move, Point $snakeHead, int $expected) {
    $move = \App\Factory\MoveFactory::create($move);
    $this->assertSame($expected, \App\Drama\Helpers::spacesAvailable($move, $snakeHead));
    // 28
})->with([
    [
        \file_get_contents(__DIR__.'/../assets/board-5.json'),
        new \App\Model\Point(1, 3),
        3,
    ],
    [
        \file_get_contents(__DIR__.'/../assets/board-5.json'),
        new \App\Model\Point(4, 4),
        29,
    ]
]);
