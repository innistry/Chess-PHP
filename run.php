<?php

require_once 'game/Gamemode.php';

say("Chess mission");

/**
 * 100 - пустая клетка
 *
 * Фигуры на доске размещаются по принципу:
 * Первая слева цифра тип фигуры
 *  2 - пешка
 *  3 - конь
 *  4 - слон
 *  5 - ладья
 *  6 - король
 *  7 - ферзь
 * Вторя цифра означает сторону
 *  1 - белые
 *  2 - черные
 * Третья цифра это состояние фигуры, к прим.
 *  221 - черная пешка, которая совершила ход на две клетки в предыдущем ходу
 * Состояние для каждой фигуры определяется индивидуально
 */
$map = [
    100, 100, 100, 100, 100, 100, 100, 100,
    100, 410, 100, 100, 100, 100, 100, 100,
    100, 100, 100, 100, 100, 100, 100, 100,
    100, 100, 100, 220, 100, 100, 100, 100,

    100, 100, 100, 100, 100, 100, 100, 100,
    100, 100, 100, 100, 100, 100, 100, 100,
    100, 100, 100, 100, 100, 100, 100, 100,
    100, 100, 100, 100, 100, 100, 100, 100,
];

$gamemode = new Gamemode($map);

$mapStr = $gamemode->mapToStr();

say("Our map:");
say($mapStr);

$availableMoves = $gamemode->getAvailableMoves($gamemode::WHITE);

say("Available moves for white: ".json_encode($availableMoves));

$availableMoves = $gamemode->getAvailableMoves($gamemode::BLACK);

say("Available moves for black: ".json_encode($availableMoves));

function say(string $str) {
    print("$str\n");
}