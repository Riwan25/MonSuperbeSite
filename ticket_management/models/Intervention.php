<?php
class Intervention {
    private ?int $id;
    private int $ticketId;
    private int $userId;
    private DateTime $startedAt;
    private DateTime $endedAt;
    private ?DateTime $createdAt;
    private ?int $startStatusId;
    private ?int $endStatusId;
    private ?string $userEmail;


    public function __construct(int $ticketId, int $userId, DateTime $startedAt, DateTime $endedAt, ?int $startStatusId = null, ?int $endStatusId = null, ?DateTime $createdAt = null, ?int $id = null, ?string $userEmail = null) { 
        $this->id = $id;
        $this->ticketId = $ticketId;
        $this->userId = $userId;
        $this->startedAt = $startedAt;
        $this->endedAt = $endedAt;
        $this->startStatusId = $startStatusId;
        $this->endStatusId = $endStatusId;
        $this->createdAt = $createdAt;        
        $this->userEmail = $userEmail;    
    }

    public function getId(){
        return $this->id;
    }
    public function getTicketId(){
        return $this->ticketId;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function getStartedAt(){
        return $this->startedAt;
    }
    public function getEndedAt(){
        return $this->endedAt;
    }
    public function getCreatedAt(){
        return $this->createdAt;
    }
    public function getStartStatusId(){
        return $this->startStatusId;
    }
    public function getEndStatusId(){
        return $this->endStatusId;
    }
    public function getUserEmail(){
        return $this->userEmail;
    }

    public function setId(int $id){
        $this->id = $id;
    }
    public function setUserId(int $userId){
        $this->userId = $userId;
    }
    public function setTicketId(int $ticketId){
        $this->ticketId = $ticketId;
    }
    public function setStartedAt(DateTime $startedAt){
        $this->startedAt = $startedAt;
    }
    public function setEndedAt(DateTime $endedAt){
        $this->endedAt = $endedAt;
    }
    public function setStartStatusId(?int $startStatusId){
        $this->startStatusId = $startStatusId;
    }
    public function setEndStatusId(?int $endStatusId){
        $this->endStatusId = $endStatusId;
    }

}