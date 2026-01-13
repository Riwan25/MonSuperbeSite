<?php

class Client {
    private string $firstName;
    private string $lastName;
    private string $phoneNumber;
    private string $email;

    public function __construct($firstName, $lastName, $phoneNumber, $email){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function getPhoneNumber(){
        return $this->phoneNumber;
    }

    public function getEmail(){
        return $this->email;
    }
}