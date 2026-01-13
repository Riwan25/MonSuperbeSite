<?php
require_once __DIR__ .'/../models/User.php';
require_once __DIR__ .'/config/Database.php';
class UserDAO {
    public static function getUser(int $userId){
        $pdo = Database::getInstance();
        $query = "
            SELECT u.id, u.email, u.leader_id, u.role_id, r.name AS role_name
            FROM users u
            JOIN roles r 
            ON u.role_id = r.id
            WHERE u.id = :userId
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getUsers() {
        $pdo = Database::getInstance();
        $query = "
            SELECT u.id, u.email, u.leader_id, r.id AS role_id, r.name AS role_name
            FROM users u
            JOIN roles r 
            ON u.role_id = r.id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createUser(User $user) {
        $pdo = Database::getInstance();
        $query = "INSERT INTO users (email, role_id, leader_id, password) VALUES (:email, :role_id, :leader_id, :password)";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':role_id', $user->getRoleId(), PDO::PARAM_STR);
        $stmt->bindValue(':leader_id', $user->getLeaderId(), PDO::PARAM_INT);
        $stmt->bindValue(':password', $user->getPassword(), PDO::PARAM_STR); //TODO crypt password
        return $stmt->execute();
    }

    public static function deleteUser(int $userId){
        $pdo = Database::getInstance();
        $query = "DELETE FROM users WHERE id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
