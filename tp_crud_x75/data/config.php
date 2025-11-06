<?php
function get_connection(){
    $server_name='localhost';
    $user_name='root';
    $password='root';
    $database='tp_crud_x75';
    $connection = mysqli_connect($server_name, $user_name, $password, $database);
    if (!$connection) {
        die("Connexion échouée : " . mysqli_connect_error());
    }
    return $connection;
}

function get_users(){
    $connection = get_connection();
    $sql = "SELECT * FROM users";

    $result = $connection->query($sql);

    if(!$result){
        die("Erreur SQL : " . $connection->error);
    }

    $connection->close();
    return $result;
}
