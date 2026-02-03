<?php

require_once(__DIR__ . "/../controllers/TicketController.php");
require_once(__DIR__ . "/../controllers/UserController.php");
require_once(__DIR__ . "/../models/Ticket.php");
require_once(__DIR__ . "/utils.php");

// Handle ticket assignment via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'assign_ticket') {
    $ticketId = intval($_POST['ticket_id']);
    $userId = intval($_POST['user_id']);
    
    if ($ticketId > 0 && $userId > 0) {
        $success = TicketController::assignTicket($ticketId, $userId);
        if ($success) {
            $_SESSION['success'] = "Ticket #$ticketId has been assigned successfully.";
        } else {
            $_SESSION['error'] = "Failed to assign ticket.";
        }
    }
    
    // Redirect to prevent form resubmission
    header("Location: supervisor.php?tab=" . ($_GET['tab'] ?? 'to_assign'));
    exit;
}

// Get current tab
$currentTab = isset($_GET['tab']) ? $_GET['tab'] : 'to_assign';

// Pagination settings
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Get tickets based on current tab
$allTickets = [];
switch ($currentTab) {
    case 'pending':
        $allTickets = TicketController::getTicketsPending();
        break;
    case 'closed':
        $allTickets = TicketController::getTicketsClosed();
        break;
    case 'to_assign':
    default:
        $allTickets = TicketController::getTicketsToAssign();
        $currentTab = 'to_assign';
        break;
}

$totalTickets = count($allTickets);
$totalPages = ceil($totalTickets / $itemsPerPage);

// Calculate offset
$offset = ($currentPage - 1) * $itemsPerPage;

// Sort tickets by priority value (descending)
usort($allTickets, function ($a, $b) {
    $priorityA = getPriorityValue($a->getPriorityId());
    $priorityB = getPriorityValue($b->getPriorityId());
    return $priorityB <=> $priorityA;
});

// Get tickets for current page
$tickets = array_slice($allTickets, $offset, $itemsPerPage);

// Get counts for each tab
$toAssignCount = count(TicketController::getTicketsToAssign());
$pendingCount = count(TicketController::getTicketsPending());
$closedCount = count(TicketController::getTicketsClosed());

// Get all users for assignment dropdown
$allUsers = UserController::getUsers();
