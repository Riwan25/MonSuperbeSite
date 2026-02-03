<?php
class Intervention {
    private ?int $id;
    private int $ticketId;
    private int $userId;
    private DateTime $startedAt;
    private DateTime $endedAt;
    private ?DateTime $createdAt;


    public function __construct(int $ticketId, int $userId, DateTime $startedAt, DateTime $endedAt, ?DateTime $createdAt = null, ?int $id = null) { 
        $this->id = $id;
        $this->ticketId = $ticketId;
        $this->userId = $userId;
        $this->startedAt = $startedAt;
        $this->endedAt = $endedAt;
        $this->createdAt = $createdAt;
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

}