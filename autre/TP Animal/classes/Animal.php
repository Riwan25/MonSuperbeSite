<?php

class Animal {
    private $id;
    private $nom;
    private $age;
    private $sex;
    private $type_id;
    private $typeLibelle;
    private $images;

    public function __construct($id = null, $nom = '', $age = null, $sex = '', $type_id = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->age = $age;
        $this->sex = $sex;
        $this->type_id = $type_id;
        $this->typeLibelle = '';
        $this->images = [];
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getAge() {
        return $this->age;
    }

    public function getSex() {
        return $this->sex;
    }

    public function getTypeId() {
        return $this->type_id;
    }

    public function getTypeLibelle() {
        return $this->typeLibelle;
    }

    public function getImages() {
        return $this->images;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function setSex($sex) {
        $this->sex = $sex;
    }

    public function setTypeId($type_id) {
        $this->type_id = $type_id;
    }

    public function setTypeLibelle($typeLibelle) {
        $this->typeLibelle = $typeLibelle;
    }

    public function setImages($images) {
        $this->images = $images;
    }

    public function addImage($image) {
        $this->images[] = $image;
    }
}
