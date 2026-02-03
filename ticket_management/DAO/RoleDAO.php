<?php
require_once __DIR__ .'/../models/Role.php';
require_once __DIR__ .'/config/Database.php';

class RoleDAO {
    public static function getRoles() {
        $pdo = Database::getInstance();
        $query = "SELECT id, name FROM roles ORDER BY id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getRoleById(int $id) {
        $pdo = Database::getInstance();
        $query = "SELECT id, name FROM roles WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
