<?php
require_once __DIR__ .'/../models/Device.php';
require_once __DIR__ .'/config/Database.php';
class DeviceDAO {
    public static function getDevice(int $id){
        $pdo = Database::getInstance();
        $query = "
            SELECT d.id, d.external_uid, d.device_type_id
            FROM devices d 
            WHERE d.id = :id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getDeviceByExternalUid(string $externalUid): ?array {
        $pdo = Database::getInstance();
        $query = "
            SELECT d.id, d.external_uid, d.device_type_id
            FROM devices d 
            WHERE d.external_uid = :external_uid
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':external_uid', $externalUid, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public static function getAllDevices(): array {
        $pdo = Database::getInstance();
        $query = "
            SELECT d.id, d.external_uid, d.device_type_id
            FROM devices d 
            ORDER BY d.external_uid
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createDevice(string $externalUid, int $deviceTypeId): int|false {
        $pdo = Database::getInstance();
        $query = "
            INSERT INTO devices (external_uid, device_type_id) 
            VALUES (:external_uid, :device_type_id)
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':external_uid', $externalUid, PDO::PARAM_STR);
        $stmt->bindParam(':device_type_id', $deviceTypeId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return (int) $pdo->lastInsertId();
        }
        return false;
    }

    public static function updateDevice(int $id, string $externalUid, int $deviceTypeId): bool {
        $pdo = Database::getInstance();
        $query = "
            UPDATE devices 
            SET external_uid = :external_uid, device_type_id = :device_type_id
            WHERE id = :id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':external_uid', $externalUid, PDO::PARAM_STR);
        $stmt->bindParam(':device_type_id', $deviceTypeId, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public static function getOrCreateDevice(string $externalUid, int $deviceTypeId): int|false {
        // First check if device exists
        $existingDevice = self::getDeviceByExternalUid($externalUid);
        if ($existingDevice) {
            if ($existingDevice['device_type_id'] !== $deviceTypeId) {
                self::updateDevice($existingDevice['id'], $externalUid, $deviceTypeId);
            }
            return $existingDevice['id'];
        }
        // Create new device
        return self::createDevice($externalUid, $deviceTypeId);
    }
}
