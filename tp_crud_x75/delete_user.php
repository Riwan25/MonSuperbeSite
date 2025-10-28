<?php
require_once 'db_connect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$conn = get_connection();
$id = intval($_GET['id']);

$user = get_user_by_id($conn, $id);

if (!$user) {
    mysqli_close($conn);
    header("Location: index.php");
    exit();
}

if (delete_user($conn, $id)) {
    mysqli_close($conn);
    header("Location: index.php?success=delete");
    exit();
} else {
    mysqli_close($conn);
    header("Location: index.php");
    exit();
}
?>
