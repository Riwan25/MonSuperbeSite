<?php

require_once __DIR__ . '/../DAO/TicketDAO.php';
class TicketController {
    public static function getTicketAssigned(int $userId){
        $data =  TicketDAO::getTicketsAssigned($userId);
        $tickets = [];
        foreach($data as $ticket){
            $tickets[] = new Ticket(
                $ticket['device_id'],
                $ticket['ticket_status_id'],
                $ticket['priority_id'],
                $ticket['description'],
                $ticket['client_id'],
                $ticket['assigned_to'],
                $ticket['id'],
                new DateTime($ticket['created_at']),
                new DateTime($ticket['updated_at']),
                null,
                $ticket['device_type_id'] ?? null
            );
        }
        return $tickets;
    }

    public static function getTicketsByLeaderId(int $leaderId){
        $data =  TicketDAO::getTicketsByLeaderId($leaderId);
        $tickets = [];
        foreach($data as $ticket){
            $tickets[] = new Ticket(
                $ticket['device_id'],
                $ticket['ticket_status_id'],
                $ticket['priority_id'],
                $ticket['description'],
                $ticket['client_id'],
                $ticket['assigned_to'],
                $ticket['id'],
                new DateTime($ticket['created_at']),
                new DateTime($ticket['updated_at']),
                $ticket['email'],
                $ticket['device_type_id'] ?? null
            );
        }
        return $tickets;
    }

    public static function getTicketById(int $ticketId){
        $data =  TicketDAO::getTicketById($ticketId);
        if ($data) {
            return new Ticket(
                $data['device_id'],
                $data['ticket_status_id'],
                $data['priority_id'],
                $data['description'],
                $data['client_id'],
                $data['assigned_to'],
                $data['id'],
                new DateTime($data['created_at']),
                new DateTime($data['updated_at']),
                $data['email'],
                $data['device_type_id'] ?? null
            );
        }
        return null;
    }

    public static function updateStatus(int $ticketId, int $statusId): bool {
        return TicketDAO::updateStatus($ticketId, $statusId);
    }

    public static function getTicketsToAssign(){
        $data = TicketDAO::getTicketsToAssign();
        $tickets = [];
        foreach($data as $ticket){
            $tickets[] = new Ticket(
                $ticket['device_id'],
                $ticket['ticket_status_id'],
                $ticket['priority_id'],
                $ticket['description'],
                $ticket['client_id'],
                $ticket['assigned_to'],
                $ticket['id'],
                new DateTime($ticket['created_at']),
                new DateTime($ticket['updated_at']),
                null,
                $ticket['device_type_id'] ?? null
            );
        }
        return $tickets;
    }

    public static function getTicketsPending(){
        $data = TicketDAO::getTicketsPending();
        $tickets = [];
        foreach($data as $ticket){
            $tickets[] = new Ticket(
                $ticket['device_id'],
                $ticket['ticket_status_id'],
                $ticket['priority_id'],
                $ticket['description'],
                $ticket['client_id'],
                $ticket['assigned_to'],
                $ticket['id'],
                new DateTime($ticket['created_at']),
                new DateTime($ticket['updated_at']),
                $ticket['email'],
                $ticket['device_type_id'] ?? null
            );
        }
        return $tickets;
    }

    public static function getTicketsClosed(){
        $data = TicketDAO::getTicketsClosed();
        $tickets = [];
        foreach($data as $ticket){
            $tickets[] = new Ticket(
                $ticket['device_id'],
                $ticket['ticket_status_id'],
                $ticket['priority_id'],
                $ticket['description'],
                $ticket['client_id'],
                $ticket['assigned_to'],
                $ticket['id'],
                new DateTime($ticket['created_at']),
                new DateTime($ticket['updated_at']),
                null,
                $ticket['device_type_id'] ?? null
            );
        }
        return $tickets;
    }

    public static function assignTicket(int $ticketId, int $userId): bool {
        return TicketDAO::assignTicket($ticketId, $userId);
    }

    public static function createTicket(int $deviceId, int $priorityId, string $description, int $clientId, ?int $assignedTo = null): int|false {
        return TicketDAO::createTicket($deviceId, $priorityId, $description, $clientId, $assignedTo);
    }

    public static function getAllTickets(): array {
        $data = TicketDAO::getAllTickets();
        $tickets = [];
        foreach ($data as $ticket) {
            $tickets[] = new Ticket(
                $ticket['device_id'],
                $ticket['ticket_status_id'],
                $ticket['priority_id'],
                $ticket['description'],
                $ticket['client_id'],
                $ticket['assigned_to'],
                $ticket['id'],
                new DateTime($ticket['created_at']),
                new DateTime($ticket['updated_at']),
                $ticket['email'],
                $ticket['device_type_id'] ?? null
            );
        }
        return $tickets;
    }

    public static function deleteTicket(int $ticketId): bool {
        return TicketDAO::deleteTicket($ticketId);
    }

    public static function updateTicket(int $ticketId, int $deviceId, int $priorityId, string $description, int $clientId): bool {
        return TicketDAO::updateTicket($ticketId, $deviceId, $priorityId, $description, $clientId);
    }
}