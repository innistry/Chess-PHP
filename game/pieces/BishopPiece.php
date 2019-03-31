<?php

require_once 'contracts/PieceInterface.php';

/**
 * TODO
 * Class BishopPiece
 */
class BishopPiece implements PieceInterface
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
        return $this->side === Gamemode::WHITE ? '♗' : '♝';
    }

    public function getSide(): int
    {
        return $this->side;
    }

    public function getAvailableMoves(): array
    {
        $moves = [];

        foreach ([Map::RIGHT_UP, Map::RIGHT_DOWN, Map::LEFT_DOWN, Map::LEFT_UP] as $direction) {
            $piece = $this;

            do {
                $piece = $this->map->getRelativePiece($piece->getCoord(), $direction);

                if ($piece && ($piece instanceof EmptyPiece || $piece->getSide() !== $this->side)) {
                    $moves []= [$this->coord, $piece->getCoord()];
                }
            } while ($piece instanceof EmptyPiece);
        }

        return $moves;
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
