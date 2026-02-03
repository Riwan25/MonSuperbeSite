<?php
require_once __DIR__ .'/../models/User.php';
require_once __DIR__ .'/config/Database.php';
class UserDAO {
    public static function getUser(string $email){
        $pdo = Database::getInstance();
        $query = "
            SELECT u.id, u.email, u.leader_id, u.role_id, r.name AS role_name, u.password, u.nb_tickets_closed
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
            SELECT u.id, u.email, u.leader_id, r.id AS role_id, r.name AS role_name, u.nb_tickets_closed
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
            SELECT u.id, u.email, u.leader_id, u.role_id, r.name AS role_name, u.password, u.nb_tickets_closed
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
            SELECT u.id, u.email, u.leader_id, u.role_id, r.name AS role_name, u.nb_tickets_closed
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

    public static function incrementTicketsClosed(int $userId) {
        $pdo = Database::getInstance();
        $query = "UPDATE users SET nb_tickets_closed = nb_tickets_closed + 1 WHERE id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Get updated count and check for promotion
        $user = self::getUserById($userId);
        if ($user) {
            $nbClosed = $user['nb_tickets_closed'];
            $currentRoleId = $user['role_id'];
            
            // Promote to Supervisor (id 3) if more than 30 tickets closed
            if ($nbClosed > 30 && $currentRoleId < 3) {
                self::updateUserRole($userId, 3);
            }
            // Promote to Team Leader (id 2) if more than 10 tickets closed
            elseif ($nbClosed > 10 && $currentRoleId < 2) {
                self::updateUserRole($userId, 2);
            }
        }
        
        return true;
    }

    public static function updateUserRole(int $userId, int $roleId) {
        $pdo = Database::getInstance();
        $query = "UPDATE users SET role_id = :role_id WHERE id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':role_id', $roleId, PDO::PARAM_INT);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
