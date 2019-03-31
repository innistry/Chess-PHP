<?php

require_once 'contracts/PieceInterface.php';

class EmptyPiece implements PieceInterface
{
    protected $map;
    protected $coord;

    public function __construct(Map $map, int $coord, int $cell)
    {
        $this->map = $map;
        $this->coord = $coord;
    }

    public function toStr(): string
    {
        return '☐';
    }

    public function getSide(): int
    {
        return 0;
    }

    public function getAvailableMoves(): array
    {
        return [];
    }

    public function getCoord(): int
    {
        return $this->coord;
    }

    public function getState(): int
    {
        return 0;
    }
}
