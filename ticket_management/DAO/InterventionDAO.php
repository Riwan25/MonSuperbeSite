<?php
require_once __DIR__ . '/../models/Intervention.php';
require_once __DIR__ . '/config/Database.php';

class InterventionDAO {
    
    public static function create(Intervention $intervention): bool {
        $pdo = Database::getInstance();
        $query = "
            INSERT INTO interventions (ticket_id, user_id, started_at, ended_at, start_status_id, end_status_id) 
            VALUES (:ticket_id, :user_id, :started_at, :ended_at, :start_status_id, :end_status_id)
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':ticket_id', $intervention->getTicketId(), PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $intervention->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':started_at', $intervention->getStartedAt()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':ended_at', $intervention->getEndedAt()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':start_status_id', $intervention->getStartStatusId(), PDO::PARAM_INT);
        $stmt->bindValue(':end_status_id', $intervention->getEndStatusId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function getInterventionsByTicketId(int $ticketId): array {
        $pdo = Database::getInstance();
        $query = "
            SELECT i.id, i.ticket_id, i.user_id, i.started_at, i.ended_at, i.created_at, i.start_status_id, i.end_status_id, u.email as user_email
            FROM interventions i
            JOIN users u ON i.user_id = u.id
            WHERE i.ticket_id = :ticket_id
            ORDER BY i.created_at DESC
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':ticket_id', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getInterventionById(int $id): ?array {
        $pdo = Database::getInstance();
        $query = "
            SELECT i.id, i.ticket_id, i.user_id, i.started_at, i.ended_at, i.created_at, i.start_status_id, i.end_status_id, u.email as user_email
            FROM interventions i
            JOIN users u ON i.user_id = u.id
            WHERE i.id = :id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public static function getInterventionsByUserId(int $userId): array {
        $pdo = Database::getInstance();
        $query = "
            SELECT i.id, i.ticket_id, i.user_id, i.started_at, i.ended_at, i.created_at, i.start_status_id, i.end_status_id
            FROM interventions i
            WHERE i.user_id = :user_id
            ORDER BY i.created_at DESC
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
