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

    public function __toString(): string
    {
        return $this->x.','.$this->y;
    }

    public function equals(Point $point): bool
    {
        return $point->x === $this->x && $point->y === $this->y;
    }

    public function moveUp(): Point
    {
        return new Point($this->x, $this->y + 1);
    }

    public function moveDown(): Point
    {
        return new Point($this->x, $this->y - 1);
    }

    public function moveLeft(): Point
    {
        return new Point($this->x - 1, $this->y);
    }

    public function moveRight(): Point
    {
        return new Point($this->x + 1, $this->y);
    }
}
