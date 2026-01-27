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
}
