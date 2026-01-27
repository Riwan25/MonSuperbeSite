<?php
session_start();

// Vider toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();


// Redirection vers la page de login
header("Location: ../views/login.php");

exit;
