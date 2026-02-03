<?php

require_once(__DIR__ . "/../controllers/TicketController.php");
require_once(__DIR__ . "/../controllers/ClientController.php");
require_once(__DIR__ . "/../controllers/DeviceController.php");
require_once(__DIR__ . "/../controllers/DeviceTypeController.php");
require_once(__DIR__ . "/../controllers/PriorityController.php");
require_once(__DIR__ . "/../controllers/StatusController.php");
require_once(__DIR__ . "/../controllers/UserController.php");
require_once(__DIR__ . "/utils.php");

// Get ticket ID from URL
$ticketId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($ticketId <= 0) {
    $_SESSION['error'] = "Invalid ticket ID.";
    header("Location: supervisor.php");
    exit;
}

// Get the ticket to edit
$ticket = TicketController::getTicketById($ticketId);
if (!$ticket) {
    $_SESSION['error'] = "Ticket not found.";
    header("Location: supervisor.php");
    exit;
}

// Get current device info
$device = DeviceController::getDevice($ticket->getDeviceId());

// Get current client info
$client = ClientController::getClientById($ticket->getClientId());

// Get all data for dropdowns
$deviceTypes = DeviceTypeController::getDeviceTypes();
$priorities = PriorityController::getPriorities();
$statuses = StatusController::getStatuses();
$clients = ClientController::getAllClients();
$allUsers = UserController::getUsers();

// Handle ticket update via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    if ($_POST['action'] === 'update_ticket') {
        $deviceTypeId = intval($_POST['device_type_id'] ?? 0);
        $externalUid = trim($_POST['external_uid'] ?? '');
        $priorityId = intval($_POST['priority_id'] ?? 0);
        $statusId = intval($_POST['status_id'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $assignedTo = !empty($_POST['assigned_to']) ? intval($_POST['assigned_to']) : null;
        
        // Client handling - either existing or new
        $clientOption = $_POST['client_option'] ?? 'existing';
        $clientId = null;
        
        if ($clientOption === 'existing') {
            $clientId = intval($_POST['client_id'] ?? 0);
        } else {
            // Create new client
            $firstName = trim($_POST['client_first_name'] ?? '');
            $lastName = trim($_POST['client_last_name'] ?? '');
            $phoneNumber = trim($_POST['client_phone'] ?? '');
            $email = trim($_POST['client_email'] ?? '') ?: null;
            
            if (empty($firstName) || empty($lastName) || empty($phoneNumber)) {
                $_SESSION['error'] = "Please fill in all required client fields (First Name, Last Name, Phone Number).";
                header("Location: updateTicket.php?id=" . $ticketId);
                exit;
            }
            
            // Check if client with phone already exists
            $existingClient = ClientController::getClientByPhone($phoneNumber);
            if ($existingClient) {
                $clientId = $existingClient->getId();
            } else {
                $clientId = ClientController::createClient($firstName, $lastName, $phoneNumber, $email);
                if (!$clientId) {
                    $_SESSION['error'] = "Failed to create client. Phone number might already exist.";
                    header("Location: updateTicket.php?id=" . $ticketId);
                    exit;
                }
            }
        }
        
        // Validate required fields
        if ($deviceTypeId <= 0 || empty($externalUid) || $priorityId <= 0 || $statusId <= 0 || empty($description) || $clientId <= 0) {
            $_SESSION['error'] = "Please fill in all required fields.";
            header("Location: updateTicket.php?id=" . $ticketId);
            exit;
        }
        
        // Get or create device
        $deviceId = DeviceController::getOrCreateDevice($externalUid, $deviceTypeId);
        if (!$deviceId) {
            $_SESSION['error'] = "Failed to create device.";
            header("Location: updateTicket.php?id=" . $ticketId);
            exit;
        }
        
        // Update ticket
        $success = TicketController::updateTicket($ticketId, $deviceId, $priorityId, $description, $clientId);
        
        if ($success) {
            // Update status if changed
            if ($statusId != $ticket->getTicketStatusId()) {
                TicketController::updateStatus($ticketId, $statusId);
            }
            
            // Handle assignment changes
            if ($assignedTo !== $ticket->getAssignedTo()) {
                if ($assignedTo) {
                    TicketController::assignTicket($ticketId, $assignedTo);
                }
            }
            
            $_SESSION['success'] = "Ticket #$ticketId has been updated successfully.";
            header("Location: supervisor.php");
            exit;
        } else {
            $_SESSION['error'] = "Failed to update ticket.";
            header("Location: updateTicket.php?id=" . $ticketId);
            exit;
        }
    }
}
