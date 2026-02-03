<?php
class Ticket {
    private ?int $id;
    private int $deviceId;
    private int $ticketStatusId;
    private int $priorityId;
    private string $description;
    private ?DateTime $createdAt;
    private ?DateTime $updatedAt;
    private ?int $assignedTo;
    private int $clientId;
    private ?string $assignedUserEmail;
    private ?int $deviceTypeId;


    public function __construct($deviceId, $ticketStatusId, $priorityId, $description, $clientId, ?int $assignedTo = null, ?int $id = null, ?DateTime $createdAt = null, ?DateTime $updatedAt = null, ?string $assignedUserEmail = null, ?int $deviceTypeId = null) {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->ticketStatusId = $ticketStatusId;
        $this->priorityId = $priorityId;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->assignedTo = $assignedTo;
        $this->clientId = $clientId;
        $this->assignedUserEmail = $assignedUserEmail;
        $this->deviceTypeId = $deviceTypeId;
    }

    public function getId(){
        return $this->id;
    }

    public function getDeviceId(){
        return $this->deviceId;
    }

    public function getTicketStatusId(){
        return $this->ticketStatusId;
    }

    public function getPriorityId(){
        return $this->priorityId;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function getUpdatedAt(){
        return $this->updatedAt;
    }

    public function getAssignedTo(){
        return $this->assignedTo;
    }

    public function getClientId(){
        return $this->clientId;
    }

    public function getAssignedUserEmail(){
        return $this->assignedUserEmail;
    }

    public function setAssignedTo(?int $assignedTo){
        $this->assignedTo = $assignedTo;
    }

    public function setTicketStatusId(int $ticketStatusId){
        $this->ticketStatusId = $ticketStatusId;
    }

    public function setUpdatedAt(DateTime $updatedAt){
        $this->updatedAt = $updatedAt;
    }

    public function setPriorityId(int $priorityId){
        $this->priorityId = $priorityId;
    }

    public function setDescription(string $description){
        $this->description = $description;
    }

    public function setDeviceId(int $deviceId){
        $this->deviceId = $deviceId;
    }

    public function setClientId(int $clientId){
        $this->clientId = $clientId;
    }

    public function getDeviceTypeId(){
        return $this->deviceTypeId;
    }

    public function setDeviceTypeId(?int $deviceTypeId){
        $this->deviceTypeId = $deviceTypeId;
    }

}