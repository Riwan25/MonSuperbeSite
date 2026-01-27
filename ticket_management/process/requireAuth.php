<?php
session_start();
function requireAuth($allowedRoles = []) {
    // Check if user is logged in
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        header('Location: ../views/login.php');
        exit();
    }
    
    // If specific roles are required, check if user has one of them
    if (!empty($allowedRoles) && !in_array($_SESSION['role_name'], $allowedRoles)) {
        header('Location: ../views/index.php');
        exit();
    }
}
?>








