<?php
require 'classes/Livre.php';
require 'classes/Animal.php';

$animaux = [
    new Animal('Rex', 5, 'chien'),
    new Animal('Miaou', 3, 'chat'),
    new Animal('Bella', 7, 'chien'),
    new Animal('Félix', 2, 'chat'),
    new Animal('Max', 4, 'chien'),
    new Animal('Whiskers', 6, 'chat')
];

$livres = [
    new Livre('Tintin', 'Casterman', 'Hergé', '1929'),
    new Livre('Astérix', 'Dargaud', 'Goscinny & Uderzo', '1959'),
    new Livre('Le Petit Prince', 'Gallimard', 'Antoine de Saint-Exupéry', '1943'),
    new Livre('Les Schtroumpfs', 'Dupuis', 'Peyo', '1958'),
];

function getlistAnimeaux() {
    global $animaux;
    $type = isset($_GET['type']) ? $_GET['type'] : 'tous';
    $animauxAffiches = [];
    if ($type === 'chiens') {
        foreach ($animaux as $animal) {
            if ($animal->getType() === 'chien') {
                $animauxAffiches[] = $animal;
            }
        }
    } elseif ($type === 'chats') {
        foreach ($animaux as $animal) {
            if ($animal->getType() === 'chat') {
                $animauxAffiches[] = $animal;
            }
        }
    } else {
        $animauxAffiches = $animaux;
    }
    return $animauxAffiches;
}

function getListDates() {
    global $livres;
    $dates = [];
    foreach ($livres as $livre) {
        $date = $livre->getDate();
        if (!in_array($date, $dates)) {
            $dates[] = $date;
        }
    }
    return $dates;
}

function getlistLivres() {
    global $livres;
    $dateFilter = isset($_GET['date']) ? $_GET['date'] : null;
    $livresAffiches = [];
    if ($dateFilter) {
        foreach ($livres as $livre) {
            if ($livre->getDate() === $dateFilter) {
                $livresAffiches[] = $livre;
            }
        }
    } else {
        $livresAffiches = $livres;
    }
    return $livresAffiches;
}
