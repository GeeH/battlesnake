<?php

declare(strict_types=1);

namespace App\Model;

class Game
{
    public function __construct(
        public readonly string $id,
        public readonly Ruleset $ruleset,
        public readonly int $timeout,
        public readonly string $source,
    ) {
    }
}
