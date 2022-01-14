<?php
// craigsimps: changed scene

test(
    'figures out the right way for a 🐍 to move',
    function (string $postedData, string $expectedResult) {
        $logger = new \Monolog\Logger('test');
        $moveHandler = new \App\Handler\MoveHandler($logger);

        $move = \App\Factory\MoveFactory::create($postedData);
        $this->assertSame($expectedResult, $moveHandler->figureOutMove($move));
    }
)->with([
    [
        \file_get_contents(__DIR__.'/assets/board-1.json'),
        'right',
    ],
    [
        \file_get_contents(__DIR__.'/assets/board-2.json'),
        'down',
    ],
    [
        \file_get_contents(__DIR__.'/assets/board-3.json'),
        'right',
    ],
]);
