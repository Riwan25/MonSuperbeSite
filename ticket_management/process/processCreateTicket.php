<?php

require_once(__DIR__ . "/../controllers/TicketController.php");
require_once(__DIR__ . "/../controllers/ClientController.php");
require_once(__DIR__ . "/../controllers/DeviceController.php");
require_once(__DIR__ . "/../controllers/DeviceTypeController.php");
require_once(__DIR__ . "/../controllers/PriorityController.php");
require_once(__DIR__ . "/../controllers/UserController.php");
require_once(__DIR__ . "/utils.php");

// Get all data for dropdowns
$deviceTypes = DeviceTypeController::getDeviceTypes();
$priorities = PriorityController::getPriorities();
$clients = ClientController::getAllClients();
$allUsers = UserController::getUsers();

// Handle ticket creation via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    if ($_POST['action'] === 'create_ticket') {
        $deviceTypeId = intval($_POST['device_type_id'] ?? 0);
        $externalUid = trim($_POST['external_uid'] ?? '');
        $priorityId = intval($_POST['priority_id'] ?? 0);
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
                header("Location: createTicket.php");
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
                    header("Location: createTicket.php");
                    exit;
                }
            }
        }
        
        // Validate required fields
        if ($deviceTypeId <= 0 || empty($externalUid) || $priorityId <= 0 || empty($description) || $clientId <= 0) {
            $_SESSION['error'] = "Please fill in all required fields.";
            header("Location: createTicket.php");
            exit;
        }
        
        // Get or create device
        $deviceId = DeviceController::getOrCreateDevice($externalUid, $deviceTypeId);
        if (!$deviceId) {
            $_SESSION['error'] = "Failed to create device.";
            header("Location: createTicket.php");
            exit;
        }
        
        // Create ticket
        $ticketId = TicketController::createTicket($deviceId, $priorityId, $description, $clientId, $assignedTo);
        
        if ($ticketId) {
            $_SESSION['success'] = "Ticket #$ticketId has been created successfully.";
            header("Location: supervisor.php?tab=to_assign");
            exit;
        } else {
            $_SESSION['error'] = "Failed to create ticket.";
            header("Location: createTicket.php");
            exit;
        }
    }
    
    if ($_POST['action'] === 'search_clients') {
        // AJAX endpoint for client search
        header('Content-Type: application/json');
        $search = trim($_POST['search'] ?? '');
        if (strlen($search) >= 2) {
            $results = ClientController::searchClients($search);
            $data = [];
            foreach ($results as $client) {
                $data[] = [
                    'id' => $client->getId(),
                    'firstName' => $client->getFirstName(),
                    'lastName' => $client->getLastName(),
                    'fullName' => $client->getFullName(),
                    'phone' => $client->getPhoneNumber(),
                    'email' => $client->getEmail()
                ];
            }
            echo json_encode($data);
        } else {
            echo json_encode([]);
        }
        exit;
    }
}
