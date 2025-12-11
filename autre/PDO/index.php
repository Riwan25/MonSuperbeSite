<?php

require_once 'classes/Database.php';
require_once 'classes/UserDAO.php';

$pdo = Database::getInstance();
echo "Connexion réussie à la base de données PDO.<br>";

$newUser = new User('Test', 'test', 40);
UserDAO::deleteUser($newUser->getId());

var_dump(UserDAO::getUsers());