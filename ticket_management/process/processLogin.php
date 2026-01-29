<?php
session_start();

require_once(__DIR__ . "/../controllers/UserController.php");
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

if ($email === '' || $pwd === '') {
    $_SESSION['login_error'] = "Please fill in all fields";
    header("Location: ../views/login.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['login_error'] = "Invalid email format";
    header("Location: ../views/login.php");
    exit;
}

$user = UserController::login($email, $pwd);

if (!$user) {
    $_SESSION['login_error'] = $_SESSION['login_error'] ?? "Incorrect email or password";
    header("Location: ../views/login.php");
    exit;
}


$_SESSION["email"]       = $user->getEmail();
$_SESSION["user_id"]     = $user->getId();
$_SESSION["role_name"]   = $user->getRoleName();
$_SESSION["logged_in"]   = true;

unset($_SESSION['login_error']);

header("Location: ../views/index.php");
exit;
