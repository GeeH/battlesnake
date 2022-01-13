<?php

test('figure out move figures out moves ', function () {
    $logger = new \Monolog\Logger('test');
    $moveHandler = new \App\Handler\MoveHandler($logger);

    $lastMove = 'down';
    $positions = <<<JSON
    [
                        {
                            "x": 6,
                            "y": 5
                        },
                        {
                            "x": 6,
                            "y": 6
                        },
                        {
                            "x": 5,
                            "y": 6
                        },
                        {
                            "x": 5,
                            "y": 5
                        },
                        {
                            "x": 5,
                            "y": 5
                        }
                    ]
    JSON;
    $snakePositions = json_decode($positions, true);

    $this->assertSame('down', $moveHandler->figureOutMove($lastMove, $snakePositions));
});
