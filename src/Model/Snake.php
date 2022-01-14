<?php

declare(strict_types=1);

namespace App\Model;

class Snake
{
    /**
     * @param  Point[]  $body
     */
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $latency,
        public readonly int $health,
        public readonly array $body,
        public readonly Point $head,
        public readonly int $length,
        public readonly string $shout,
        public readonly string $squad,
        public readonly Customizations $customizations,
    ) {
    }
}
