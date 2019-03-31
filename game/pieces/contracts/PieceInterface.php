<?php

interface PieceInterface
{
    public function __construct(Map $map, int $coord, int $cell);

    public function toStr(): string;

    public function getSide(): int;

    public function getCoord(): int;

    public function getState(): int;

    public function getAvailableMoves(): array;
}
