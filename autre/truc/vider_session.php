<?php
session_start();

$_SESSION['clients'] = array();

header('Location: traitement.php');
exit();
?>
