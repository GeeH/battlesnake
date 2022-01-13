<?php
// craigsimps: changed scene

test(
    'figures out the right way for a 🐍 to move',
    function ($postedData, $expectedResult) {
        $logger = new \Monolog\Logger('test');
        $moveHandler = new \App\Handler\MoveHandler($logger);

        $this->assertSame($expectedResult, $moveHandler->figureOutMove($postedData));
    }
)->with([
            [
                json_decode(\file_get_contents(__DIR__ . '/assets/board-1.json'), true),
                'right',
            ],
            [
                json_decode(file_get_contents(__DIR__ . '/assets/board-2.json'), true),
                'down',
            ]


        ]);
