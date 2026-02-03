<?php
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/config/Database.php';

class ClientDAO {
    
    public static function getAllClients(): array {
        $pdo = Database::getInstance();
        $query = "
            SELECT id, first_name, last_name, phone_number, email 
            FROM clients 
            ORDER BY last_name, first_name
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getClientById(int $id): ?array {
        $pdo = Database::getInstance();
        $query = "
            SELECT id, first_name, last_name, phone_number, email 
            FROM clients 
            WHERE id = :id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public static function getClientByPhone(string $phoneNumber): ?array {
        $pdo = Database::getInstance();
        $query = "
            SELECT id, first_name, last_name, phone_number, email 
            FROM clients 
            WHERE phone_number = :phone
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':phone', $phoneNumber, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public static function searchClients(string $search): array {
        $pdo = Database::getInstance();
        $searchTerm = '%' . $search . '%';
        $query = "
            SELECT id, first_name, last_name, phone_number, email 
            FROM clients 
            WHERE first_name LIKE :search 
               OR last_name LIKE :search2 
               OR phone_number LIKE :search3 
               OR email LIKE :search4
            ORDER BY last_name, first_name
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(':search2', $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(':search3', $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(':search4', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createClient(string $firstName, string $lastName, string $phoneNumber, ?string $email = null): int|false {
        $pdo = Database::getInstance();
        $query = "
            INSERT INTO clients (first_name, last_name, phone_number, email) 
            VALUES (:first_name, :last_name, :phone_number, :email)
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return (int) $pdo->lastInsertId();
        }
        return false;
    }

    public static function updateClient(int $id, string $firstName, string $lastName, string $phoneNumber, ?string $email = null): bool {
        $pdo = Database::getInstance();
        $query = "
            UPDATE clients 
            SET first_name = :first_name, 
                last_name = :last_name, 
                phone_number = :phone_number, 
                email = :email 
            WHERE id = :id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public static function deleteClient(int $id): bool {
        $pdo = Database::getInstance();
        $query = "DELETE FROM clients WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
