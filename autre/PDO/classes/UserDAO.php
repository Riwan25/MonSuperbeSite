<?php
require_once 'User.php';
class UserDAO {
    public static function getUsers(){
        $pdo = Database::getInstance();
        $query = "SELECT * FROM users";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getUser($id){
        $pdo = Database::getInstance();
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function createUser(User $user){
        $pdo = Database::getInstance();
        $query = "INSERT INTO users (first_name, last_name) VALUES (:firstname, :lastname)";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':firstname', $user->getFirstname(), PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $user->getLastname(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    public static function updateUser(User $user){
        $pdo = Database::getInstance();
        $query = "UPDATE users SET first_name = :firstname, last_name = :lastname WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':firstname', $user->getFirstname(), PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $user->getLastname(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $user->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function deleteUser($id){
        $pdo = Database::getInstance();
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
