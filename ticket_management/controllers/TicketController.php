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
                new DateTime($ticket['updated_at'])
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
                new DateTime($ticket['updated_at'])
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
                new DateTime($data['updated_at'])
            );
        }
        return null;
    }
}