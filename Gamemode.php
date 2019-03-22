<?php

require_once 'Map.php';

require_once 'pieces/EmptyPiece.php';

class Gamemode
{
    const WHITE = 1;
    const BLACK = 2;

    protected $map;

    public function __construct(array $map)
    {
        $this->map = new Map($map);
    }

    public function mapToStr(): string
    {
        return $this->map->toStr();
    }

    public function getAvailableMoves(int $side): array
    {
        $moves = [];

        $coord = 0;

        do {
            $piece = $this->map[$coord];

            if ($piece instanceof EmptyPiece) {
                continue;
            }

            if ($piece->getSide() === $side) {
                $moves = array_merge($moves, $piece->getAvailableMoves());
            }
        } while ($this->map->offsetExists(++$coord));

        return $moves;
    }
}
