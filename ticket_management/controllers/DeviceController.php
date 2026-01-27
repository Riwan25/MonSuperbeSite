<?php

require_once __DIR__ . '/../DAO/DeviceDAO.php';
class DeviceController {
    public static function getDevice(int $id){
        $data =  DeviceDAO::getDevice($id);
        return new Device(
            $data['external_uid'],
            $data['device_type_id'],
            $data['id']
        );
    }
}