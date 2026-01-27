<?php
session_start();

require_once(__DIR__ . "/../controllers/UserController.php");
require_once(__DIR__ . "/../DAO/UserDAO.php");
require_once(__DIR__ . "/../models/User.php");

// Protection contre fixation de session
if (empty($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$pwd   = trim($_POST['password'] ?? '');
$confirmPwd = trim($_POST['confirm_password'] ?? '');

if ($email === '' || $pwd === '' || $confirmPwd === '') {
    $_SESSION['register_error'] = "Please fill in all fields";
    header("Location: ../views/login.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['register_error'] = "Invalid email format";
    header("Location: ../views/login.php");
    exit;
}

if (strlen($pwd) < 8) {
    $_SESSION['register_error'] = "Password must be at least 8 characters long";
    header("Location: ../views/login.php");
    exit;
}

if ($pwd !== $confirmPwd) {
    $_SESSION['register_error'] = "Passwords do not match";
    header("Location: ../views/login.php");
    exit;
}

$result = UserController::register($email, $pwd);

if (!$result) {
    $_SESSION['register_error'] = $_SESSION['error'] ?? "Error during registration";
    header("Location: ../views/login.php");
    exit;
}

$_SESSION['register_success'] = "Account created successfully! You can now log in.";
unset($_SESSION['register_error']);

header("Location: ../views/login.php");
exit;
