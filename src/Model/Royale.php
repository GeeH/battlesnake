<?php

declare(strict_types=1);

namespace App\Model;

class Royale
{
    public function __construct(
        public readonly int $shrinkEveryNTurns
    ) { }
}
