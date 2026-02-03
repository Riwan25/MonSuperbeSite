<?php
require_once __DIR__ .'/../models/Comment.php';
require_once __DIR__ .'/config/Database.php';
class CommentDAO {
    public static function create(int $ticketId, int $userId, string $content): bool {
        $pdo = Database::getInstance();
        $query = "
            INSERT INTO comments (ticket_id, user_id, content) 
            VALUES (:ticket_id, :user_id, :content)
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':ticket_id', $ticketId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public static function getCommentsByTicketId(string $ticketId) {
        $pdo = Database::getInstance();
        $query = "
            SELECT c.id, c.ticket_id, c.user_id, c.content, c.created_at, u.email 
            FROM comments c
            JOIN users u 
            ON c.user_id = u.id
            WHERE c.ticket_id = :id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
