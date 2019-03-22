<?php

require_once 'Gamemode.php';

say("Chess mission");

$map = [
    90, 10, 10, 10, 10, 10, 10, 10,
    10, 10, 10, 10, 10, 10, 10, 10,
    10, 10, 10, 10, 10, 10, 10, 10,
    10, 10, 10, 10, 10, 10, 10, 10,

    10, 10, 10, 10, 10, 10, 10, 10,
    10, 10, 10, 10, 10, 10, 10, 10,
    10, 10, 10, 10, 10, 10, 10, 10,
];

$gamemode = new Gamemode;

$gamemode->init($map);

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