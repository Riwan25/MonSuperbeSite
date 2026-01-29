<?php

require_once __DIR__ . '/../DAO/StatusDAO.php';
class StatusController {
    private static $statuses = null;
    public static function getStatuses(){
        if (self::$statuses == null) {
            $data =  StatusDAO::getStatuses();
            $statuses = [];
            foreach($data as $status){
                $statuses[] = new Status(
                    $status['name'],
                    $status['id']
                );
            }
            self::$statuses = $statuses;
        }
        return self::$statuses;
    }
}