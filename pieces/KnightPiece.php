<?php

require_once 'contracts/PieceInterface.php';

/**
 * TODO
 * Class KnightPiece
 */
class KnightPiece implements PieceInterface
{
    protected $map;
    protected $coord;
    protected $side = Gamemode::WHITE;

    public function __construct(Map $map, int $coord, int $cell)
    {
        $this->map = $map;
        $this->side = substr($cell, 1, 1) == Gamemode::WHITE ? Gamemode::WHITE : Gamemode::BLACK;
        $this->coord = $coord;
    }

    public function toStr(): string
    {
        return $this->side === Gamemode::WHITE ? '♘' : '♞';
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
