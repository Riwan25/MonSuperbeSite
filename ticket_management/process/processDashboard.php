<?php

require_once(__DIR__ . "/../controllers/TicketController.php");
require_once(__DIR__ . "/../models/Ticket.php");
require_once(__DIR__ . "/../controllers/DeviceTypeController.php");
require_once(__DIR__ . "/../controllers/PriorityController.php");
require_once(__DIR__ . "/../controllers/StatusController.php");
require_once(__DIR__ . "/../controllers/UserController.php");

// Detect which page is calling this script
$isTeamLeaderPage = isset($isTeamLeaderView) && $isTeamLeaderView === true;

// Pagination settings
$itemsPerPage = 20;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Get all tickets based on the page
$allTickets = [];
if ($isTeamLeaderPage) {
    $allTickets = TicketController::getTicketsByLeaderId($_SESSION['user_id']);
} else {
    $allTickets = TicketController::getTicketAssigned($_SESSION['user_id']);
}
$totalTickets = count($allTickets);
$totalPages = ceil($totalTickets / $itemsPerPage);

// Calculate offset
$offset = ($currentPage - 1) * $itemsPerPage;

// Get tickets for current page
$tickets = array_slice($allTickets, $offset, $itemsPerPage);

$deviceTypes = DeviceTypeController::getDeviceTypes();
function getDeviceTypeName($deviceTypeId) {
    global $deviceTypes;
    foreach ($deviceTypes as $type) {
        if ($type->getId() == $deviceTypeId) {
            return $type->getName();
        }
    }
    return "Unknown";
}

$priorities = PriorityController::getPriorities();
function getPriorityName($priorityId) {
    global $priorities;
    foreach ($priorities as $priority) {
        if ($priority->getId() == $priorityId) {
            return $priority->getName();
        }
    }
    return "Unknown";
}

$statuses = StatusController::getStatuses();
function getStatusName($statusId) {
    global $statuses;
    foreach ($statuses as $status) {
        if ($status->getId() == $statusId) {
            return $status->getName();
        }
    }
    return "Unknown";
}

// Get all users for team leader view (to display assigned user email)
$users = UserController::getUsers();
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