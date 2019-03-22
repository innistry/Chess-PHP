<?php

require_once 'Map.php';

class Gamemode
{
    const WHITE = 1;
    const BLACK = 2;

    protected $map;

    public function init(array $map)
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

        foreach ($this->map as $piece) {
            if ($piece->getSide() === $side) {
                $moves []= $piece->getAvailableMoves();
            }
        }

        return $moves;
    }
}
