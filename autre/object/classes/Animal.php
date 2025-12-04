<?php

class Animal {
    private $nom;
    private $age;
    private $type;

    public function __construct($nom, $age, $type) {
        $this->nom = $nom;
        $this->age = $age;
        $this->type = $type;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getAge() {
        return $this->age;
    }

    public function getType() {
        return $this->type;
    }
}



