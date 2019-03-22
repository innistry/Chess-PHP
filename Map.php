<?php

require_once 'Gamemode.php';

require_once 'pieces/contracts/PieceInterface.php';
require_once 'pieces/EmptyPiece.php';
require_once 'pieces/PawnPiece.php';
require_once 'pieces/KnightPiece.php';
require_once 'pieces/BishopPiece.php';
require_once 'pieces/RockPiece.php';
require_once 'pieces/KingPiece.php';
require_once 'pieces/QueenPiece.php';

class Map implements ArrayAccess
{
    const EMPTY_CELL = 1;
    const PAWN_CELL = 2;
    const KNIGHT_CELL = 3;
    const BISHOP_CELL = 4;
    const ROCK_CELL = 5;
    const KING_CELL = 6;
    const QUEEN_CELL = 7;

    const MAP_MINIMUM_COUNT = 64;

    const UP = 1;
    const RIGHT_UP = 2;
    const RIGHT = 3;
    const RIGHT_DOWN = 4;
    const DOWN = 5;
    const LEFT_DOWN = 6;
    const LEFT = 7;
    const LEFT_UP = 8;

    private $map = [];

    public function __construct(array $map)
    {
        assert(count($map) === self::MAP_MINIMUM_COUNT, 'Too small map');

        foreach ($map as $coord => $cell) {
            $piece = $this->makePiece($cell, $coord);

            assert($piece != null, 'Not valid cell');

            $this->map []= $piece;
        }
    }

    protected function isValidCell($cell)
    {
        return in_array($this->getPieceConst($cell), [
            self::EMPTY_CELL,
            self::PAWN_CELL,
            self::KNIGHT_CELL,
            self::BISHOP_CELL,
            self::ROCK_CELL,
            self::KING_CELL,
            self::QUEEN_CELL,
        ]);
    }

    protected function getPieceConst(int $cell)
    {
        return (int) ($cell / 100);
    }

    private function makePiece(int $cell, int $coord): ?PieceInterface
    {
        switch ($this->getPieceConst($cell)) {
            case self::EMPTY_CELL:
                return new EmptyPiece($this, $coord, $cell);
            case self::PAWN_CELL:
                return new PawnPiece($this, $coord, $cell);
            case self::KNIGHT_CELL:
                return new KnightPiece($this, $coord, $cell);
            case self::BISHOP_CELL:
                return new BishopPiece($this, $coord, $cell);
            case self::ROCK_CELL:
                return new RockPiece($this, $coord, $cell);
            case self::KING_CELL:
                return new KingPiece($this, $coord, $cell);
            case self::QUEEN_CELL:
                return new QueenPiece($this, $coord, $cell);
            default:
                return null;
        }
    }

    public function toStr(): string
    {
        $str = '';

        foreach ($this->map as $coord => $piece) {
            $str .= $piece->toStr().' ';

            if (($coord + 1) % 8 === 0) {
                $str .= "\n";
            }
        }

        return $str;
    }

    public function getRelativePiece($fromCoord, $direction): ?PieceInterface
    {
        switch ($direction) {
            case self::UP:
                $relativeCoord = $fromCoord - 8;
                break;

            case self::RIGHT_UP:
                $relativeCoord = $fromCoord - 7;
                break;

            case self::RIGHT:
                $relativeCoord = $fromCoord + 1;
                break;

            case self::RIGHT_DOWN:
                $relativeCoord = $fromCoord + 9;
                break;

            case self::DOWN:
                $relativeCoord = $fromCoord + 8;
                break;

            case self::LEFT_DOWN:
                $relativeCoord = $fromCoord + 7;
                break;

            case self::LEFT:
                $relativeCoord = $fromCoord - 1;
                break;

            case self::LEFT_UP:
                $relativeCoord = $fromCoord - 9;
                break;

            default:
                return null;
        }

        return isset($this->map[$relativeCoord]) ? $this->map[$relativeCoord] : null;
    }

    public function offsetSet($coord, $cell)
    {
        $piece = $this->makePiece($cell, $coord);

        assert($piece != null, 'Not valid cell');

        $this->map[$coord] = $piece;
    }

    public function offsetExists($coord): bool
    {
        return isset($this->map[$coord]);
    }

    public function offsetUnset($coord)
    {
        unset($this->map[$coord]);
    }

    public function offsetGet($coord): ?PieceInterface
    {
        return isset($this->map[$coord]) ? $this->map[$coord] : null;
    }
}
