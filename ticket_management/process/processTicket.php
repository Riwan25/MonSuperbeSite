<?php

require_once(__DIR__ . "/../controllers/TicketController.php");
require_once(__DIR__ . "/../controllers/CommentController.php");
require_once(__DIR__ . "/../controllers/DeviceTypeController.php");
require_once(__DIR__ . "/../controllers/PriorityController.php");
require_once(__DIR__ . "/../controllers/StatusController.php");
require_once(__DIR__ . "/../controllers/UserController.php");

// Get ticket ID from URL
$ticketId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($ticketId <= 0) {
    header("Location: index.php");
    exit;
}

// Get ticket by ID
$ticket = TicketController::getTicketById($ticketId);

if (!$ticket) {
    header("Location: index.php");
    exit;
}

// Get comments for this ticket
$comments = CommentController::getCommentsByTicketId($ticketId);

// Get lookup data
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

function getUserEmail($userId) {
    global $users;
    if ($userId === null) {
        return "Unassigned";
    }
    foreach ($users as $user) {
        if ($user->getId() == $userId) {
            return $user->getEmail();
        }
    }
    return "Unknown";
}
