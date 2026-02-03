<?php
require_once __DIR__ .'/../models/Ticket.php';
require_once __DIR__ .'/config/Database.php';
class TicketDAO {
    public static function getTicketsAssigned(string $userId) {
        $pdo = Database::getInstance();
        $query = "
            SELECT t.id, t.device_id, t.ticket_status_id, t.priority_id, t.description, t.assigned_to, t.client_id, t.created_at, t.updated_at 
            FROM tickets t 
            WHERE t.assigned_to = :id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTicketsByLeaderId(int $leaderId) {
        $pdo = Database::getInstance();
        $query = "
            SELECT t.id, t.device_id, t.ticket_status_id, t.priority_id, t.description, t.assigned_to, t.client_id, t.created_at, t.updated_at, u.email 
            FROM tickets t 
            JOIN users u 
            ON t.assigned_to = u.id
            JOIN users leader
            ON u.leader_id = leader.id
            WHERE leader.id = :id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $leaderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTicketById(int $ticketId) {
        $pdo = Database::getInstance();
        $query = "
            SELECT t.id, t.device_id, t.ticket_status_id, t.priority_id, t.description, t.assigned_to, t.client_id, t.created_at, t.updated_at, u.email 
            FROM tickets t 
            JOIN users u 
            ON t.assigned_to = u.id
            WHERE t.id = :id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
