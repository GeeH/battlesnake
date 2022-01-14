<?php

use App\Factory\MoveFactory;
use App\Model\Game;
use App\Model\Move;

test('it maps incoming move to a Move model', function () {
    $json = file_get_contents(__DIR__.'/assets/board-2.json');

    $move = MoveFactory::create($json);
    $this->assertInstanceOf(Move::class, $move);
    $this->assertSame(5, $move->turn,);
    $this->assertInstanceOf(Game::class, $move->game);
    $this->assertCount(5, $move->board->snakes);
    $this->assertSame(10, $move->board->snakes[0]->body[0]->x);
    $this->assertSame('default', $move->you->customizations->head);
});

