<?php

require_once(__DIR__ . "/../controllers/TicketController.php");
require_once(__DIR__ . "/../controllers/CommentController.php");
require_once(__DIR__ . "/../controllers/DeviceController.php");
require_once(__DIR__ . "/../controllers/UserController.php");
require_once(__DIR__ . "/../controllers/InterventionController.php");
require_once(__DIR__ . "/utils.php");

// Get ticket ID from URL
$ticketId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($ticketId <= 0) {
    header("Location: index.php");
    exit;
}

// Get ticket by ID
$ticket = TicketController::getTicketById($ticketId);

$device = DeviceController::getDevice($ticket->getDeviceId());

if (!$ticket) {
    header("Location: index.php");
    exit;
}

// Get comments for this ticket
$comments = CommentController::getCommentsByTicketId($ticketId);

// Get all users for assignment (supervisor only)
$allUsers = [];
if (isset($_SESSION['role_name']) && $_SESSION['role_name'] === 'Supervisor') {
    $allUsers = UserController::getUsers();
}

// Get interventions for this ticket (supervisor and team leader)
$interventions = [];
if (isset($_SESSION['role_name']) && ($_SESSION['role_name'] === 'Supervisor' || $_SESSION['role_name'] === 'Team Leader')) {
    $interventions = InterventionController::getInterventionsByTicketId($ticketId);
}

// Handle assign ticket action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'assign_ticket' && isset($_SESSION['role_name']) && $_SESSION['role_name'] === 'Supervisor') {
        $userId = intval($_POST['user_id'] ?? 0);
        
        if ($userId > 0) {
            $success = TicketController::assignTicket($ticketId, $userId);
            if ($success) {
                $_SESSION['success'] = "Ticket has been assigned successfully.";
            } else {
                $_SESSION['error'] = "Failed to assign ticket.";
            }
        } else {
            $_SESSION['error'] = "Please select a user to assign.";
        }
        
        header("Location: ticket.php?id=" . $ticketId);
        exit;
    }
}


