<?php

require_once(__DIR__ . "/../controllers/TicketController.php");
require_once(__DIR__ . "/../controllers/CommentController.php");
require_once(__DIR__ . "/utils.php");

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

