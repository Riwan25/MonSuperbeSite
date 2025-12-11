<?php

// Modifier l’exercice précédent pour qu’un joueur aie une liste d’armes plutôt
// qu’une seule arme.
// Afficher le joueur avec sa liste d’armes.

require_once 'Arme.php';
class Player {
    private $nom;
    private $force;
    private $pv;
    private $armes = [];

    public function __construct($nom, $force, $pv, array $armes) {
        $this->nom = $nom;
        $this->force = $force;
        $this->pv = $pv;
        $this->armes = $armes;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getForce() {
        return $this->force;
    }

    public function getPv() {
        return $this->pv;
    }

    public function getArme() {
        return $this->armes;
    }
}