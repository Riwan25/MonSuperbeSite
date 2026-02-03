
<?php
require_once(__DIR__ . "/../controllers/DeviceTypeController.php");
require_once(__DIR__ . "/../controllers/PriorityController.php");
require_once(__DIR__ . "/../controllers/StatusController.php");
require_once(__DIR__ . "/../controllers/UserController.php");

$deviceTypes = DeviceTypeController::getDeviceTypes();
$priorities = PriorityController::getPriorities();
$statuses = StatusController::getStatuses();
$users = UserController::getUsers();

function getPriorityName($priorityId) {
    global $priorities;
    foreach ($priorities as $priority) {
        if ($priority->getId() == $priorityId) {
            return $priority->getName();
        }
    }
    return "Unknown";
}

function getPriorityValue($priorityId) {
    global $priorities;
    foreach ($priorities as $priority) {
        if ($priority->getId() == $priorityId) {
            return $priority->getValue();
        }
    }
    return 0;
}

function getDeviceTypeName($deviceTypeId) {
    global $deviceTypes;
    foreach ($deviceTypes as $type) {
        if ($type->getId() == $deviceTypeId) {
            return $type->getName();
        }
    }
    return "Unknown";
}

function getStatusName($statusId) {
    global $statuses;
    foreach ($statuses as $status) {
        if ($status->getId() == $statusId) {
            return $status->getName();
        }
    }
    return "Unknown";
}