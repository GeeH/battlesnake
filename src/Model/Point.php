<?php

declare(strict_types=1);

namespace App\Model;

class Point
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
    ) {
    }
}
