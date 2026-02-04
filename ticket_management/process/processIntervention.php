<?php

require_once(__DIR__ . "/../controllers/InterventionController.php");
require_once(__DIR__ . "/../controllers/TicketController.php");
require_once(__DIR__ . "/../controllers/StatusController.php");
require_once(__DIR__ . "/../controllers/CommentController.php");
require_once(__DIR__ . "/../controllers/UserController.php");

// Get ticket ID from URL
$ticketId = isset($_GET['ticket_id']) ? intval($_GET['ticket_id']) : 0;

if ($ticketId <= 0) {
    header("Location: index.php");
    exit;
}

// Get ticket to verify it exists
$ticket = TicketController::getTicketById($ticketId);

if (!$ticket) {
    header("Location: index.php");
    exit;
}

// Get all available statuses for the select dropdown
$statuses = StatusController::getStatuses();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startedAt = isset($_POST['started_at']) ? $_POST['started_at'] : '';
    $endedAt = isset($_POST['ended_at']) ? $_POST['ended_at'] : '';
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $statusId = isset($_POST['status_id']) ? intval($_POST['status_id']) : 0;
    
    $errors = [];
    
    // Validate inputs
    if (empty($startedAt)) {
        $errors[] = "Start date/time is required.";
    }
    if (empty($endedAt)) {
        $errors[] = "End date/time is required.";
    }
    if ($statusId <= 0) {
        $errors[] = "Please select a valid status.";
    }
    
    if (empty($errors)) {
        try {
            $startDateTime = new DateTime($startedAt);
            $endDateTime = new DateTime($endedAt);
            
            // Validate that end time is after start time
            if ($endDateTime <= $startDateTime) {
                $errors[] = "End date/time must be after start date/time.";
            } else {
                // Get current user ID from session
                $userId = $_SESSION['user_id'];
                
                // Get the current ticket status (this will be the start_status_id)
                $startStatusId = $ticket->getTicketStatusId();
                
                // The selected status will be the end_status_id
                $endStatusId = $statusId;
                
                // Create intervention with start and end status
                $success = InterventionController::create($ticketId, $userId, $startDateTime, $endDateTime, $startStatusId, $endStatusId);
                
                if ($success) {
                    // Update ticket status
                    TicketController::updateStatus($ticketId, $statusId);
                    
                    // If ticket is closed (status_id = 5), increment user's closed tickets counter
                    if ($statusId === 5) {
                        UserController::incrementTicketsClosed($userId);
                    }
                    
                    // Create comment if provided
                    if (!empty($comment)) {
                        CommentController::create($ticketId, $userId, $comment);
                    }
                    
                    header("Location: ticket.php?id=" . $ticketId . "&success=1");
                    exit;
                } else {
                    $errors[] = "Failed to create intervention. Please try again.";
                }
            }
        } catch (Exception $e) {
            $errors[] = "Invalid date/time format.";
        }
    }
}
