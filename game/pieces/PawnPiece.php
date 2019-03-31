<?php

require_once 'contracts/PieceInterface.php';
require_once 'EmptyPiece.php';

class PawnPiece implements PieceInterface
{
    protected $map;
    protected $coord;
    protected $side = Gamemode::WHITE;
    protected $state = 0;

    /*
     * States
     */
    const HAS_NOT_MOVE = 0;
    const HAS_MADE_TWO_CELLS_MOVE = 1;
    const TOUCHED = 2;

    public function __construct(Map $map, int $coord, int $cell)
    {
        $this->map = $map;
        $this->side = substr($cell, 1, 1) == Gamemode::WHITE ? Gamemode::WHITE : Gamemode::BLACK;
        $this->coord = $coord;

        $state = (int) substr($cell, 2, 1);
        $this->state = $state;
    }

    public function toStr(): string
    {
        return $this->side === Gamemode::WHITE ? '♙' : '♟';
    }

    public function getSide(): int
    {
        return $this->side;
    }

    public function getAvailableMoves(): array
    {
        $moves = [];

        $forward = $this->side === Gamemode::WHITE ? Map::UP : Map::DOWN;
        $attackRight = $this->side === Gamemode::WHITE ? Map::RIGHT_UP : Map::RIGHT_DOWN;
        $attackLeft = $this->side === Gamemode::WHITE ? Map::LEFT_UP : Map::LEFT_DOWN;

        $piece = $this->map->getRelativePiece($this->coord, $forward);

        if ($piece && $piece instanceof EmptyPiece) {
            $moves []= [$this->coord, $piece->getCoord()];

            if ($this->state === self::HAS_NOT_MOVE) {
                $piece = $this->map->getRelativePiece($piece->getCoord(), $forward);

                if ($piece && $piece instanceof EmptyPiece) {
                    $moves []= [$this->coord, $piece->getCoord()];
                }
            }
        }

        $piece = $this->map->getRelativePiece($this->coord, $attackRight);

        if ($piece) {
            if (!($piece instanceof EmptyPiece) && $piece->getSide() !== $this->side) {
                $moves []= [$this->coord, $piece->getCoord()];
            }

            $piece = $this->map->getRelativePiece($this->coord, Map::RIGHT);

            if ($piece instanceof PawnPiece && $piece->getSide() !== $this->side && $piece->getState() === self::HAS_MADE_TWO_CELLS_MOVE) {
                $moves []= [$this->coord, $piece->getCoord()];
            }
        }

        $piece = $this->map->getRelativePiece($this->coord, $attackLeft);

        if ($piece) {
            if (!($piece instanceof EmptyPiece) && $piece->getSide() !== $this->side) {
                $moves []= [$this->coord, $piece->getCoord()];
            }

            $piece = $this->map->getRelativePiece($this->coord, Map::LEFT);

            if ($piece instanceof PawnPiece && $piece->getSide() !== $this->side && $piece->getState() === self::HAS_MADE_TWO_CELLS_MOVE) {
                $moves []= [$this->coord, $piece->getCoord()];
            }
        }

        return $moves;
    }

    public function getCoord(): int
    {
        return $this->coord;
    }

    public function getState(): int
    {
        return $this->state;
    }
}
