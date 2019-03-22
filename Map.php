<?php

require_once 'Gamemode.php';

require_once 'pieces/contracts/PieceInterface.php';
require_once 'pieces/EmptyPiece.php';
require_once 'pieces/BishopPiece.php';
require_once 'pieces/KingPiece.php';
require_once 'pieces/KnightPiece.php';
require_once 'pieces/PawnPiece.php';
require_once 'pieces/QueenPiece.php';
require_once 'pieces/RockPiece.php';

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

    private $map = [];

    private $pieces = [];

    public function __construct(array $map)
    {
        assert(count($map) === self::MAP_MINIMUM_COUNT, 'Too small map');

        foreach ($map as $cell) {
            assert($this->isValidCell($cell), 'Not valid map');
        }

        $this->map = $map;

        $this->initPieces();
    }

    protected function isValidCell($cell)
    {
        return in_array($cell / 10, [
            self::EMPTY_CELL,
            self::PAWN_CELL,
            self::KNIGHT_CELL,
            self::BISHOP_CELL,
            self::ROCK_CELL,
            self::KING_CELL,
            self::QUEEN_CELL,
        ]);
    }

    protected function initPieces()
    {
        $this->pieces = [
            self::EMPTY_CELL => new EmptyPiece($this),
            self::PAWN_CELL => new BishopPiece($this),
            self::KNIGHT_CELL => new KingPiece($this),
            self::BISHOP_CELL => new KnightPiece($this),
            self::ROCK_CELL => new PawnPiece($this),
            self::KING_CELL => new QueenPiece($this),
            self::QUEEN_CELL => new RockPiece($this),
        ];
    }

    public function toStr(): string
    {
        $str = '';

        foreach ($this->map as $cell) {
            $piece = $this->getPiece($cell);

            $str .= $piece->toStr().'|';
        }

        return $str;
    }

    private function getPiece(int $cell): PieceInterface
    {
        return $this->pieces[$cell / 10].init($cell);
    }

    public function offsetSet($offset, $cell)
    {
        assert($this->isValidCell($cell), 'Not valid cell');

        $this->map[$offset] = $cell;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->map[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->map[$offset]);
    }

    public function offsetGet($offset): ?PieceInterface
    {
        return isset($this->map[$offset]) ? $this->getPiece($this->map[$offset]) : null;
    }
}
