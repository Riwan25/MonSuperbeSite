<?php
class User {
    private $firstname;
    private $lastname;
    private $id;

    public function __construct($firstname, $lastname, $id = null){
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->id = $id;
    }

    public function getFirstname(){
        return $this->firstname;
    }

    public function getLastname(){
        return $this->lastname;
    }

    public function getId(){
        return $this->id;
    }
}