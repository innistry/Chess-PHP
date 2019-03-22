<?php

require_once 'Gamemode.php';
require_once 'Map.php';

say("Chess mission");

$map = [
    100, 100, 100, 100, 100, 100, 100, 100,
    100, 100, 100, 100, 100, 100, 100, 100,
    100, 100, 100, 221, 212, 100, 100, 100,
    100, 100, 100, 100, 100, 100, 100, 100,

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