<?php

require_once __DIR__ . '/../DAO/DeviceTypeDAO.php';
class DeviceTypeController {
    private static $deviceTypes = null;
    public static function getDeviceTypes(){
        if (self::$deviceTypes == null) {
            $data =  DeviceTypeDAO::getDeviceTypes();
            $deviceTypes = [];
            foreach($data as $deviceType){
                $deviceTypes[] = new DeviceType(
                    $deviceType['name'],
                    $deviceType['id']
                );
            }
            self::$deviceTypes = $deviceTypes;
        }
        return self::$deviceTypes;
    }
}