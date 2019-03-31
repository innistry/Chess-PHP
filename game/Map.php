<?php

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

    const UP = - 8;
    const RIGHT_UP = - 7;
    const RIGHT = 1;
    const RIGHT_DOWN = 9;
    const DOWN = 8;
    const LEFT_DOWN = 7;
    const LEFT = - 1;
    const LEFT_UP = - 9;

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

    protected function isValidCell(int $cell)
    {
        return strlen($cell) === 3 && in_array($this->getPieceConst($cell), [
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
        if ($fromCoord % 8 == 0 && in_array($direction, [self::LEFT, self::LEFT_DOWN, self::LEFT_UP])) {
            return null;
        }

        if ($fromCoord % 8 == 7 && in_array($direction, [self::RIGHT, self::RIGHT_DOWN, self::RIGHT_UP])) {
            return null;
        }

        $relativeCoord = $fromCoord + $direction;

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
