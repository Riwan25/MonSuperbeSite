<?php
class User {
    private ?int $id;
    private string $email;
    private int $roleId;
    private ?string $roleName;
    private ?int $leaderId;
    private ?string $password;
    private int $nbTicketsClosed;

    public function __construct($email, $roleId, ?int $leaderId, ?int $id = null, ?string $roleName = null, ?string $password = null, int $nbTicketsClosed = 0) { 
        $this->id = $id;
        $this->email = $email;
        $this->roleId = $roleId;
        $this->leaderId = $leaderId;
        $this->roleName = $roleName;
        $this->password = $password;
        $this->nbTicketsClosed = $nbTicketsClosed;
    }

    public function getId(){
        return $this->id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getRoleId(){
        return $this->roleId;
    }

    public function getLeaderId(){
        return $this->leaderId;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRoleName(){
        return $this->roleName;
    }

    public function getNbTicketsClosed(){
        return $this->nbTicketsClosed;
    }

}