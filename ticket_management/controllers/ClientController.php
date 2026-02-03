<?php

require_once __DIR__ . '/../DAO/ClientDAO.php';

class ClientController {
    
    public static function getAllClients(): array {
        $data = ClientDAO::getAllClients();
        $clients = [];
        foreach ($data as $client) {
            $clients[] = new Client(
                $client['first_name'],
                $client['last_name'],
                $client['phone_number'],
                $client['email'],
                $client['id']
            );
        }
        return $clients;
    }

    public static function getClientById(int $id): ?Client {
        $data = ClientDAO::getClientById($id);
        if ($data) {
            return new Client(
                $data['first_name'],
                $data['last_name'],
                $data['phone_number'],
                $data['email'],
                $data['id']
            );
        }
        return null;
    }

    public static function getClientByPhone(string $phoneNumber): ?Client {
        $data = ClientDAO::getClientByPhone($phoneNumber);
        if ($data) {
            return new Client(
                $data['first_name'],
                $data['last_name'],
                $data['phone_number'],
                $data['email'],
                $data['id']
            );
        }
        return null;
    }

    public static function searchClients(string $search): array {
        $data = ClientDAO::searchClients($search);
        $clients = [];
        foreach ($data as $client) {
            $clients[] = new Client(
                $client['first_name'],
                $client['last_name'],
                $client['phone_number'],
                $client['email'],
                $client['id']
            );
        }
        return $clients;
    }

    public static function createClient(string $firstName, string $lastName, string $phoneNumber, ?string $email = null): int|false {
        // Check if client with this phone number already exists
        $existingClient = ClientDAO::getClientByPhone($phoneNumber);
        if ($existingClient) {
            return false;
        }
        return ClientDAO::createClient($firstName, $lastName, $phoneNumber, $email);
    }

    public static function updateClient(int $id, string $firstName, string $lastName, string $phoneNumber, ?string $email = null): bool {
        return ClientDAO::updateClient($id, $firstName, $lastName, $phoneNumber, $email);
    }

    public static function deleteClient(int $id): bool {
        return ClientDAO::deleteClient($id);
    }

    public static function getOrCreateClient(string $firstName, string $lastName, string $phoneNumber, ?string $email = null): int|false {
        // First check if client exists by phone number
        $existingClient = ClientDAO::getClientByPhone($phoneNumber);
        if ($existingClient) {
            return $existingClient['id'];
        }
        // Create new client
        return ClientDAO::createClient($firstName, $lastName, $phoneNumber, $email);
    }
}
