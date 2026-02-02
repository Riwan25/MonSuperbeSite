<?php
class Comment {
    private ?int $id;
    private int $userId;
    private int $content;
    private ?DateTime $createdAt;
    private ?string $userEmail;


    public function __construct($userId, $content, ?int $id = null, ?DateTime $createdAt = null, ?string $userEmail = null) { 
        $this->id = $id;
        $this->userId = $userId;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->userEmail = $userEmail;
    }

    public function getId(){
        return $this->id;
    }

    public function getUserId(){
        return $this->userId;
    }

    public function getContent(){
        return $this->content;
    }

    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function getUserEmail(){
        return $this->userEmail;
    }

    public function setUserEmail($email){
        $this->userEmail = $email;
    }

    public function setCreatedAt(DateTime $createdAt){
        $this->createdAt = $createdAt;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function setContent($content){
        $this->content = $content;
    }

    public function setUserId(int $userId){
        $this->userId = $userId;
    }
}