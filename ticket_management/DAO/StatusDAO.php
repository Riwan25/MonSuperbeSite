<?php
require_once __DIR__ .'/../models/Status.php';
require_once __DIR__ .'/config/Database.php';
class StatusDAO {
    public static function getStatuses(){
        $pdo = Database::getInstance();
        $query = "
            SELECT ts.id, ts.name
            FROM ticket_statuses ts
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
