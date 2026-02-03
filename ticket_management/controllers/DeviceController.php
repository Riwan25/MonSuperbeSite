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

    public static function getDeviceByExternalUid(string $externalUid): ?Device {
        $data = DeviceDAO::getDeviceByExternalUid($externalUid);
        if ($data) {
            return new Device(
                $data['external_uid'],
                $data['device_type_id'],
                $data['id']
            );
        }
        return null;
    }

    public static function getAllDevices(): array {
        $data = DeviceDAO::getAllDevices();
        $devices = [];
        foreach ($data as $device) {
            $devices[] = new Device(
                $device['external_uid'],
                $device['device_type_id'],
                $device['id']
            );
        }
        return $devices;
    }

    public static function createDevice(string $externalUid, int $deviceTypeId): int|false {
        return DeviceDAO::createDevice($externalUid, $deviceTypeId);
    }

    public static function getOrCreateDevice(string $externalUid, int $deviceTypeId): int|false {
        return DeviceDAO::getOrCreateDevice($externalUid, $deviceTypeId);
    }
}