<?php

class Cours {
    private $id;
    private $libelle;
    private $description;
    private $image;
    private $id_type;

    public function __construct($id = null, $libelle = null, $description = null, $image = null, $id_type = null) {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->description = $description;
        $this->image = $image;
        $this->id_type = $id_type;
    }

    public function getId() {
        return $this->id;
    }

    public function getLibelle() {
        return $this->libelle;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getImage() {
        return $this->image;
    }
    public function getIdType() {
        return $this->id_type;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setIdType($id_type) {
        $this->id_type = $id_type;
    }
}
