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
            LEFT JOIN users u 
            ON t.assigned_to = u.id
            WHERE t.id = :id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateStatus(int $ticketId, int $statusId): bool {
        $pdo = Database::getInstance();
        
        // Status IDs: 2 = 'To re assign', 5 = 'Closed'
        // If status is 'To re assign' or 'Closed', clear the assigned_to field
        if ($statusId == 2 || $statusId == 5) {
            $query = "
                UPDATE tickets 
                SET ticket_status_id = :status_id, assigned_to = NULL, updated_at = NOW()
                WHERE id = :ticket_id
            ";
        } else {
            $query = "
                UPDATE tickets 
                SET ticket_status_id = :status_id, updated_at = NOW()
                WHERE id = :ticket_id
            ";
        }
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':status_id', $statusId, PDO::PARAM_INT);
        $stmt->bindValue(':ticket_id', $ticketId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function getTicketsToAssign() {
        $pdo = Database::getInstance();
        // Status 1 = 'To assign', Status 2 = 'To re assign'
        $query = "
            SELECT t.id, t.device_id, t.ticket_status_id, t.priority_id, t.description, t.assigned_to, t.client_id, t.created_at, t.updated_at 
            FROM tickets t 
            WHERE t.ticket_status_id IN (1, 2)
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTicketsPending() {
        $pdo = Database::getInstance();
        // Status 3 = 'Pending', Status 4 = 'Resolved'
        $query = "
            SELECT t.id, t.device_id, t.ticket_status_id, t.priority_id, t.description, t.assigned_to, t.client_id, t.created_at, t.updated_at, u.email 
            FROM tickets t 
            LEFT JOIN users u ON t.assigned_to = u.id
            WHERE t.ticket_status_id IN (3, 4)
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTicketsClosed() {
        $pdo = Database::getInstance();
        // Status 5 = 'Closed'
        $query = "
            SELECT t.id, t.device_id, t.ticket_status_id, t.priority_id, t.description, t.assigned_to, t.client_id, t.created_at, t.updated_at 
            FROM tickets t 
            WHERE t.ticket_status_id = 5
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function assignTicket(int $ticketId, int $userId): bool {
        $pdo = Database::getInstance();
        // Status 3 = 'Pending'
        $query = "
            UPDATE tickets 
            SET assigned_to = :user_id, ticket_status_id = 3, updated_at = NOW()
            WHERE id = :ticket_id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':ticket_id', $ticketId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function createTicket(int $deviceId, int $priorityId, string $description, int $clientId, ?int $assignedTo = null): int|false {
        $pdo = Database::getInstance();
        // Status 1 = 'To assign' (default for new tickets)
        $statusId = $assignedTo ? 3 : 1; // If assigned, set to 'Pending', else 'To assign'
        
        $query = "
            INSERT INTO tickets (device_id, ticket_status_id, priority_id, description, client_id, assigned_to, created_at, updated_at) 
            VALUES (:device_id, :status_id, :priority_id, :description, :client_id, :assigned_to, NOW(), NOW())
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':device_id', $deviceId, PDO::PARAM_INT);
        $stmt->bindValue(':status_id', $statusId, PDO::PARAM_INT);
        $stmt->bindValue(':priority_id', $priorityId, PDO::PARAM_INT);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':client_id', $clientId, PDO::PARAM_INT);
        $stmt->bindValue(':assigned_to', $assignedTo, $assignedTo ? PDO::PARAM_INT : PDO::PARAM_NULL);
        
        if ($stmt->execute()) {
            return (int) $pdo->lastInsertId();
        }
        return false;
    }

    public static function getAllTickets(): array {
        $pdo = Database::getInstance();
        $query = "
            SELECT t.id, t.device_id, t.ticket_status_id, t.priority_id, t.description, t.assigned_to, t.client_id, t.created_at, t.updated_at, u.email 
            FROM tickets t 
            LEFT JOIN users u ON t.assigned_to = u.id
            ORDER BY t.created_at DESC
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteTicket(int $ticketId): bool {
        $pdo = Database::getInstance();
        $query = "DELETE FROM tickets WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id', $ticketId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function updateTicket(int $ticketId, int $deviceId, int $priorityId, string $description, int $clientId): bool {
        $pdo = Database::getInstance();
        $query = "
            UPDATE tickets 
            SET device_id = :device_id, 
                priority_id = :priority_id, 
                description = :description, 
                client_id = :client_id,
                updated_at = NOW()
            WHERE id = :ticket_id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':device_id', $deviceId, PDO::PARAM_INT);
        $stmt->bindValue(':priority_id', $priorityId, PDO::PARAM_INT);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':client_id', $clientId, PDO::PARAM_INT);
        $stmt->bindValue(':ticket_id', $ticketId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
