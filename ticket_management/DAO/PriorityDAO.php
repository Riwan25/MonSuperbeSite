<?php
require_once __DIR__ .'/../models/Priority.php';
require_once __DIR__ .'/config/Database.php';
class PriorityDAO {
    public static function getPriorities(){
        $pdo = Database::getInstance();
        $query = "
            SELECT p.id, p.name, p.value
            FROM priorities p
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
