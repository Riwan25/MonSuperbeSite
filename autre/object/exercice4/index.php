<?php 
class Maison {
    private static $lastId = 0;
    private $id;
    private $dateCreation;
    private $nombreChambres;
    private $surface;

    public function __construct($dateCreation, $nombreChambres, $surface) {
        self::$lastId++;
        $this->id = self::$lastId;
        $this->dateCreation = $dateCreation;
        $this->nombreChambres = $nombreChambres;
        $this->surface = $surface;
    }

    // Méthodes pour accéder aux attributs privés
    public function getId() {
        return $this->id;
    }

    public function getDateCreation() {
        return $this->dateCreation;
    }

    public function getNombreChambres() {
        return $this->nombreChambres;
    }

    public function getSurface() {
        return $this->surface;
    }
}