<?php

function get_connection(){
    $server_name='localhost';
    $user_name='root';
    $password='root';
    $database='tp_crud_x75';
    $connection = mysqli_connect($server_name, $user_name, $password, $database);
    if(!$connection){
        die("connection échouée: " . mysqli_connect_error());
    }
    mysqli_set_charset($connection, "utf8mb4");
    return $connection;
}

// Fonction pour calculer l'âge à partir d'une date de naissance
function calculate_age($birthdate) {
    $date = DateTime::createFromFormat('Y-m-d', $birthdate);
    if (!$date) return false;
    
    $today = new DateTime();
    return $today->diff($date)->y;
}

// Fonction pour valider le prénom ou le nom
function validate_name($name, $field_name) {
    $errors = [];
    if (empty($name)) {
        $errors[] = "Le $field_name est obligatoire.";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s'-]{2,50}$/u", $name)) {
        $errors[] = "Le $field_name doit contenir entre 2 et 50 caractères alphabétiques.";
    }
    return $errors;
}

// Fonction pour valider l'email
function validate_email($email) {
    $errors = [];
    if (empty($email)) {
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }
    return $errors;
}

// Fonction pour valider le genre
function validate_gender($gender) {
    $errors = [];
    if (empty($gender)) {
        $errors[] = "Le genre est obligatoire.";
    } elseif (!in_array($gender, ['Homme', 'Femme'])) {
        $errors[] = "Le genre doit être 'Homme' ou 'Femme'.";
    }
    return $errors;
}

// Fonction pour valider la date de naissance
function validate_birthdate($birthdate) {
    $errors = [];
    if (empty($birthdate)) {
        $errors[] = "La date de naissance est obligatoire.";
    } else {
        $date = DateTime::createFromFormat('Y-m-d', $birthdate);
        if (!$date || $date->format('Y-m-d') !== $birthdate) {
            $errors[] = "La date de naissance n'est pas valide.";
        } else {
            $today = new DateTime();
            $age = $today->diff($date)->y;
            
            if ($age < 10) {
                $errors[] = "Vous devez avoir au moins 10 ans.";
            } elseif ($age > 99) {
                $errors[] = "L'âge ne peut pas dépasser 99 ans.";
            }
        }
    }
    return $errors;
}

// Fonction pour vérifier si un email existe déjà
function email_exists($conn, $email, $exclude_id = null) {
    $sql = "SELECT id FROM users WHERE email = ?";
    if ($exclude_id !== null) {
        $sql .= " AND id != ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $email, $exclude_id);
    } else {
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $exists = mysqli_num_rows($result) > 0;
    mysqli_stmt_close($stmt);
    
    return $exists;
}

// Fonction pour récupérer tous les utilisateurs
function get_all_users($conn) {
    $sql = "SELECT * FROM users ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Fonction pour récupérer un utilisateur par ID
function get_user_by_id($conn, $id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    return $user;
}

// Fonction pour ajouter un utilisateur
function add_user($conn, $firstname, $lastname, $email, $gender, $birthdate, $age) {
    $sql = "INSERT INTO users (firstname, lastname, email, gender, birthdate, age) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $firstname, $lastname, $email, $gender, $birthdate, $age);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    return $success;
}

// Fonction pour mettre à jour un utilisateur
function update_user($conn, $id, $firstname, $lastname, $email, $gender, $birthdate, $age) {
    $sql = "UPDATE users SET firstname = ?, lastname = ?, email = ?, gender = ?, birthdate = ?, age = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssii", $firstname, $lastname, $email, $gender, $birthdate, $age, $id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    return $success;
}

// Fonction pour supprimer un utilisateur
function delete_user($conn, $id) {
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    return $success;
}