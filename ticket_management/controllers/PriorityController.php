<?php

require_once __DIR__ . '/../DAO/PriorityDAO.php';
class PriorityController {
    private static $priorities = null;
    public static function getPriorities(){
        if (self::$priorities == null) {
            $data =  PriorityDAO::getPriorities();
            $priorities = [];
            foreach($data as $priority){
                $priorities[] = new Priority(
                    $priority['name'],
                    $priority['value'],
                    $priority['id']
                );
            }
            self::$priorities = $priorities;
        }
        return self::$priorities;
    }
}