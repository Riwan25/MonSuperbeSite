<?php

require 'process.php';

$listePlayers = getListePlayers();

foreach ($listePlayers as $player) {
    echo '<div>';
    echo '<h2>' . htmlspecialchars($player->getNom()) . '</h2>';
    echo '<div>Force : ' . $player->getForce() . '</div>';
    echo '<div>Points de vie : ' . $player->getPv() . '</div>';
    $armes = $player->getArme();
    echo '<div>Armes :</div><ul>';
    foreach ($armes as $arme) {
        echo '<li><img src="' . htmlspecialchars($arme->getImagePath()) . '" alt="' . htmlspecialchars($arme->getImagePath()) . '"></li>';
        echo  htmlspecialchars($arme->getNom()) . ' (Dégâts : ' . $arme->getDegats() . ')';
    }
    echo '</ul>';

    echo '</div><br>--------------------------------<br>';
}