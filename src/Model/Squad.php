<?php

declare(strict_types=1);

namespace App\Model;

class Squad
{
    public function __construct(
        public readonly bool $allowBodyCollisions,
        public readonly bool $sharedElimination,
        public readonly bool $sharedHealth,
        public readonly bool $sharedLength,
    ) {
    }
}
