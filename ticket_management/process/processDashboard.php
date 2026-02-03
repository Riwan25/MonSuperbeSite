<?php

require_once(__DIR__ . "/../controllers/TicketController.php");
require_once(__DIR__ . "/../models/Ticket.php");
require_once(__DIR__ . "/utils.php");


// Detect which page is calling this script
$isTeamLeaderPage = isset($isTeamLeaderView) && $isTeamLeaderView === true;

// Pagination settings
$itemsPerPage = 10;
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

// Sort tickets by priority value
usort($tickets, function ($a, $b) {
    $priorityA = getPriorityValue($a->getPriorityId());
    $priorityB = getPriorityValue($b->getPriorityId());

    return $priorityB <=> $priorityA; // descending order
});
