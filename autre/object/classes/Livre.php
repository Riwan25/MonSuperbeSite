<?php
class Livre {
    private $nom;
    private $edition;
    private $auteur;
    private $date;

    // Constructeur
    public function __construct($nom, $edition, $auteur, $date) {
        $this->nom = $nom;
        $this->edition = $edition;
        $this->auteur = $auteur;
        $this->date = $date;
    }

    // Getters
    public function getNom() {
        return $this->nom;
    }

    public function getEdition() {
        return $this->edition;
    }

    public function getAuteur() {
        return $this->auteur;
    }

    public function getDate() {
        return $this->date;
    }
}


