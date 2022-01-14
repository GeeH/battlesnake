<?php

declare(strict_types=1);

namespace App\Model;

class Ruleset
{
    public function __construct(
        public readonly string $name,
        public readonly string $version,
        public readonly Settings $settings,
    ) { }
}
