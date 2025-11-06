<?php
session_start();
require_once __DIR__ . "/../data/userDAO.php";
if (isset($_POST['saveUser'])) {
   $lastname = trim($_POST['lastname'] ?? '');
   $firstname = trim($_POST['firstname'] ?? '');
   $email = trim($_POST['email'] ?? '');
   $birthdate = trim($_POST['birthdate'] ?? '');
   $gender = trim($_POST['gender'] ?? '');
   
   $user = [
       'lastname' => $lastname,
       'firstname' => $firstname,
       'email' => $email,
       'birthdate' => $birthdate,
       'gender' => $gender,
   ];

   if (empty($user['firstname']) || empty($user['email']) || empty($user['lastname']) || empty($user['email']) || empty($user['birthdate']) || empty($user['gender'])) {
       $_SESSION['error'] = "Erreur: Tous les champs sont obligatoires.";
       header("Location: ../view/userForm.php"); 
       exit();
   }
   saveUser($user);
   header("Location: ../view/index.php?success=add");
   exit();
}

if (isset($_GET['delete'])) {
   $idUser = intval($_GET['delete']);
   deleteUser($idUser);
   header("Location: ../view/index.php?success=delete");
   exit();
}

if (isset($_POST['updateUser'])) {
    $idUser = intval($_POST['idUser'] ?? 0);
    $lastname = trim($_POST['lastname'] ?? '');
    $firstname = trim($_POST['firstname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $birthdate = trim($_POST['birthdate'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    
    $user = [
        'id' => $idUser,
        'lastname' => $lastname,
        'firstname' => $firstname,
        'email' => $email,
        'birthdate' => $birthdate,
        'gender' => $gender,
    ];
    updateUser($user);
    header("Location: ../view/index.php?success=update");
    exit();
}


function getUsers(){
    $users=getUsersDAO();
   return $users ;
}

function getUserById($id){
    $users = getUsersDAO();
    foreach($users as $user){
        if($user['id'] == $id){
            return $user;
        }
    }
    return null;
}

function saveUser($user){
   saveUserDAO($user);
}

function deleteUser($idUser){
    deleteUserDAO($idUser);
}
function updateUser($user){
    updateUserDAO($user);
}
?>