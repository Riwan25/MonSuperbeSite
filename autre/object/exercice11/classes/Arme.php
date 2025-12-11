<?php
class Arme {
    private static $lastId = 0;
    private $id;
    private $nom;
    private $degats;
    private $level;

    public function __construct($nom, $degats, $level) {
        self::$lastId++;
        $this->id = self::$lastId;
        $this->nom = $nom;
        $this->degats = $degats;
        $this->level = $level;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getDegats() {
        return $this->degats;
    }

    public function getImagePath() {
        return "images/" . strtolower($this->nom). "/" . strtolower($this->nom) . $this->level . ".png";
    }
}

class Arc extends Arme {
    public function __construct($level) {
        parent::__construct("Arc", 15,  $level);
    }
}

class Epee extends Arme {
    public function __construct($level) {
        parent::__construct("Epee", 25,  $level);
    }
}

class Fleau extends Arme {
    public function __construct($level) {
        parent::__construct("Fleau", 30,  $level);
    }
}

class Hache extends Arme {
    public function __construct($level) {
        parent::__construct("Hache", 20,  $level);
    }
}