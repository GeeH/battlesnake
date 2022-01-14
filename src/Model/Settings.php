<?php

declare(strict_types=1);

namespace App\Model;

class Settings
{
    public function __construct(
        public readonly int $foodSpawnChance,
        public readonly int $minimumFood,
        public readonly int $hazardDamagePerTurn,
        public readonly Royale $royale,
        public readonly Squad $squad,
    ) { }
}
