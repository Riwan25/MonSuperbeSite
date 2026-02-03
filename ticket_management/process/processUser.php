<?php

require_once(__DIR__ . "/../controllers/UserController.php");
require_once(__DIR__ . "/../controllers/RoleController.php");

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'create_user':
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $roleId = intval($_POST['role_id'] ?? 1);
            $leaderId = !empty($_POST['leader_id']) ? intval($_POST['leader_id']) : null;
            
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Email and password are required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format.";
            } elseif (strlen($password) < 6) {
                $_SESSION['error'] = "Password must be at least 6 characters.";
            } else {
                $success = UserController::register($email, $password, $roleId, $leaderId);
                if ($success) {
                    $_SESSION['success'] = "User created successfully.";
                }
            }
            
            header("Location: user.php");
            exit;
            
        case 'update_user':
            $userId = intval($_POST['user_id'] ?? 0);
            $email = trim($_POST['email'] ?? '');
            $roleId = intval($_POST['role_id'] ?? 1);
            $leaderId = !empty($_POST['leader_id']) ? intval($_POST['leader_id']) : null;
            $password = $_POST['password'] ?? '';
            
            if ($userId <= 0) {
                $_SESSION['error'] = "Invalid user ID.";
            } elseif (empty($email)) {
                $_SESSION['error'] = "Email is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format.";
            } elseif (!empty($password) && strlen($password) < 6) {
                $_SESSION['error'] = "Password must be at least 6 characters.";
            } else {
                $passwordToUpdate = !empty($password) ? $password : null;
                $success = UserController::updateUser($userId, $email, $roleId, $leaderId, $passwordToUpdate);
                if ($success) {
                    $_SESSION['success'] = "User updated successfully.";
                }
            }
            
            header("Location: user.php");
            exit;
            
        case 'delete_user':
            $userId = intval($_POST['user_id'] ?? 0);
            
            if ($userId <= 0) {
                $_SESSION['error'] = "Invalid user ID.";
            } elseif ($userId === $_SESSION['user_id']) {
                $_SESSION['error'] = "You cannot delete your own account.";
            } else {
                $success = UserController::deleteUser($userId);
                if ($success) {
                    $_SESSION['success'] = "User deleted successfully.";
                }
            }
            
            header("Location: user.php");
            exit;
            
        case 'assign_leader':
            $userId = intval($_POST['user_id'] ?? 0);
            $leaderId = intval($_POST['leader_id'] ?? 0);
            
            if ($userId <= 0 || $leaderId <= 0) {
                $_SESSION['error'] = "Invalid user or leader ID.";
            } else {
                $success = UserController::assignLeader($userId, $leaderId);
                if ($success) {
                    $_SESSION['success'] = "Leader assigned successfully.";
                }
            }
            
            header("Location: user.php");
            exit;
    }
}

// Get all users
$allUsers = UserController::getUsers();

// Get all roles
$roles = RoleController::getRoles();

// Get team leaders for leader dropdown
$teamLeaders = UserController::getTeamLeaders();

// Pagination settings
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$totalUsers = count($allUsers);
$totalPages = ceil($totalUsers / $itemsPerPage);
$offset = ($currentPage - 1) * $itemsPerPage;

// Get users for current page
$users = array_slice($allUsers, $offset, $itemsPerPage);
