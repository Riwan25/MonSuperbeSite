<?php
require_once __DIR__ . "/config.php";

function getUsersDAO(){

    $connection = get_connection();
    $sql = "SELECT * FROM users";
    $result = $connection->query($sql);

    if(!$result){
        die("Erreur SQL : " . $connection->error);
    }
    
    $users = $result->fetch_all(MYSQLI_ASSOC); 
    $connection->close();
    return $users;
}


function saveUserDAO($user){
    $birthDate = new DateTime($user['birthdate']);
    $today = new DateTime();
    $age = $birthDate->diff($today)->y;
    $connection = get_connection();
    $query = "INSERT INTO users (firstname, lastname, email, gender, birthdate, age) VALUES (?, ?, ?, ?, ?, ?)";
    $statement = $connection->prepare($query);
        
    if ($statement === false) {
        error_log("Erreur de préparation SQL: " . $connection->error);
        exit();
    }
    
    $success = $statement->bind_param(
        "sssssi",
        $user['firstname'],
        $user['lastname'],
        $user['email'],
        $user['gender'],
        $user['birthdate'],
        $age
    );
    if ($success === false) {
        error_log("Erreur de liaison des paramètres: " . $statement->error);
        $statement->close();
        $connection->close();
        exit();
    }
    $success = $statement->execute();
    
    if (!$success) {
        error_log("Erreur d'exécution SQL: " . $statement->error);
    }
    
    $statement->close();
    $connection->close();
}

function deleteUserDAO($idUser){
    $query = "DELETE FROM users WHERE id = ?";
    $connection = get_connection();
    $statement = $connection->prepare($query);
    if ($statement === false) {
        error_log("Erreur de préparation SQL: " . $connection->error);
        return false;
    }
    $success = $statement->bind_param("i", $idUser);
    if ($success === false) {
        error_log("Erreur de liaison des paramètres: " . $statement->error);
        $statement->close();
        $connection->close();
        return false;
    }
    $success = $statement->execute();
    if (!$success) {
        error_log("Erreur d'exécution SQL: " . $statement->error);
        return false;
    }
    if ($statement->affected_rows > 0) {
        $statement->close();
        $connection->close();
        return true;
    }
    $statement->close();
    $connection->close();
    return true;
}

function updateUserDAO($user){
    $birthDate = new DateTime($user['birthdate']);
    $today = new DateTime();
    $age = $birthDate->diff($today)->y;
    $connection = get_connection();
    $query = "UPDATE users SET firstname = ?, lastname = ?, email = ?, gender = ?, birthdate = ?, age = ? WHERE id = ?";
    $statement = $connection->prepare($query);
    if ($statement === false) {
        error_log("Erreur de préparation SQL: " . $connection->error);
        exit();
    }
    $success = $statement->bind_param(
        "sssssis",
        $user['firstname'],
        $user['lastname'],
        $user['email'],
        $user['gender'],
        $user['birthdate'],
        $age,
        $user['id']
    );
    if ($success === false) {
        error_log("Erreur de liaison des paramètres: " . $statement->error);
        $statement->close();
        $connection->close();
        exit();
    }
    $success = $statement->execute();
    if (!$success) {
        error_log("Erreur d'exécution SQL: " . $statement->error);
    }
    $statement->close();
    $connection->close();
}

?>