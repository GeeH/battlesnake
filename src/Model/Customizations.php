<?php

declare(strict_types=1);

namespace App\Model;

class Customizations
{
    public function __construct(
        public readonly string $color,
        public readonly string $head,
        public readonly string $tail,
    ) {
    }
}
