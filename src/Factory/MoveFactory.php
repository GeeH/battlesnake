<?php

declare(strict_types=1);

namespace App\Factory;

use App\Model\Move;
use CuyZ\Valinor\Mapper\Source\JsonSource;
use CuyZ\Valinor\MapperBuilder;

class MoveFactory
{
    public static function create(string $json): Move
    {
        return (new MapperBuilder())
            ->mapper()
            ->map(
                Move::class,
                new JsonSource($json)
            );
    }
}
