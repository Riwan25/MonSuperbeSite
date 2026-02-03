<?php
require_once __DIR__ .'/../models/User.php';
require_once __DIR__ .'/config/Database.php';
class UserDAO {
    public static function getUser(string $email){
        $pdo = Database::getInstance();
        $query = "
            SELECT u.id, u.email, u.leader_id, u.role_id, r.name AS role_name, u.password
            FROM users u
            JOIN roles r 
            ON u.role_id = r.id
            WHERE u.email = :email
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
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
        $stmt->bindValue(':password', password_hash($user->getPassword(), PASSWORD_BCRYPT), PDO::PARAM_STR);
        return $stmt->execute();
    }

    public static function deleteUser(int $userId){
        $pdo = Database::getInstance();
        $query = "DELETE FROM users WHERE id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function getUserById(int $userId) {
        $pdo = Database::getInstance();
        $query = "
            SELECT u.id, u.email, u.leader_id, u.role_id, r.name AS role_name, u.password
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

    public static function updateUser(int $userId, string $email, int $roleId, ?int $leaderId, ?string $password = null) {
        $pdo = Database::getInstance();
        
        if ($password !== null && $password !== '') {
            $query = "UPDATE users SET email = :email, role_id = :role_id, leader_id = :leader_id, password = :password WHERE id = :userId";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
        } else {
            $query = "UPDATE users SET email = :email, role_id = :role_id, leader_id = :leader_id WHERE id = :userId";
            $stmt = $pdo->prepare($query);
        }
        
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':role_id', $roleId, PDO::PARAM_INT);
        $stmt->bindValue(':leader_id', $leaderId, PDO::PARAM_INT);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public static function getTeamLeaders() {
        $pdo = Database::getInstance();
        $query = "
            SELECT u.id, u.email, u.leader_id, u.role_id, r.name AS role_name
            FROM users u
            JOIN roles r ON u.role_id = r.id
            WHERE r.name = 'team_leader' OR r.name = 'supervisor'
            ORDER BY u.email
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function assignLeader(int $userId, int $leaderId) {
        $pdo = Database::getInstance();
        $query = "UPDATE users SET leader_id = :leader_id WHERE id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':leader_id', $leaderId, PDO::PARAM_INT);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
