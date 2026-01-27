<?php
require_once __DIR__ .'/../models/User.php';
require_once __DIR__ .'/config/Database.php';
class DeviceTypeDAO {
    public static function getDeviceTypes(){
        $pdo = Database::getInstance();
        $query = "
            SELECT dt.id, dt.name
            FROM device_types dt 
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
