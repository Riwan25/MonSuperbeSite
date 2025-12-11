<?php

require_once './classes/Arme.php';
require_once './classes/Player.php';

$listePlayers = [
    new Player('Arthur', 15, 100, [new Epee(1), new Arc(2)]),
    new Player('Lancelot', 20, 120, [new Hache(1), new Fleau(3)]),
    new Player('Merlin', 10, 80, [new Arc(1), new Epee(2)]),
    new Player('Guenièvre', 12, 90, [new Fleau(5), new Hache(4)]),
];

function getListePlayers() {
    global $listePlayers;
    return $listePlayers;
}