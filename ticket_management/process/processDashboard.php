<?php

require_once(__DIR__ . "/../controllers/TicketController.php");
require_once(__DIR__ . "/../models/Ticket.php");
require_once(__DIR__ . "/utils.php");


$isTeamLeaderPage = isset($isTeamLeaderView) && $isTeamLeaderView === true;

// Pagination settings
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Get all tickets based on the page
$allTickets = [];
if ($isTeamLeaderPage) {
    // Get current tab for team leader
    $currentTab = isset($_GET['tab']) ? $_GET['tab'] : 'pending';
    
    switch ($currentTab) {
        case 'closed':
            $allTickets = TicketController::getTicketsByLeaderIdClosed($_SESSION['user_id']);
            break;
        case 'other':
            $allTickets = TicketController::getTicketsByLeaderIdOther($_SESSION['user_id']);
            break;
        case 'pending':
        default:
            $allTickets = TicketController::getTicketsByLeaderIdPending($_SESSION['user_id']);
            $currentTab = 'pending';
            break;
    }
    
    // Get counts for each tab
    $pendingCount = count(TicketController::getTicketsByLeaderIdPending($_SESSION['user_id']));
    $closedCount = count(TicketController::getTicketsByLeaderIdClosed($_SESSION['user_id']));
    $otherCount = count(TicketController::getTicketsByLeaderIdOther($_SESSION['user_id']));
} else {
    $allTickets = TicketController::getTicketAssigned($_SESSION['user_id']);
}
$totalTickets = count($allTickets);
$totalPages = ceil($totalTickets / $itemsPerPage);

// Calculate offset
$offset = ($currentPage - 1) * $itemsPerPage;

// Sort tickets by priority value
usort($allTickets, function ($a, $b) {
    $priorityA = getPriorityValue($a->getPriorityId());
    $priorityB = getPriorityValue($b->getPriorityId());

    return $priorityB <=> $priorityA; // descending order
});

// Get tickets for current page
$tickets = array_slice($allTickets, $offset, $itemsPerPage);
