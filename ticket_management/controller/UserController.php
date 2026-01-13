<?php

require_once __DIR__ . '/../DAO/UserDAO.php';
class UserController {
    public static function getUser(int $userId){
        $data = UserDAO::getUser($userId);
        return new User(
            $data['email'],
            $data['role_id'],
            $data['leader_id'],
            $data['id'],
            $data['role_name']
        );
    }

    public static function getUsers(){
        $data =  UserDAO::getUsers();
        $users = [];
        foreach($data as $userData){
            $users[] = new User(
                $userData['email'],
                $userData['role_id'],
                $userData['leader_id'],
                $userData['id'],
                $userData['role_name']
            );
        }
        return $users;
    }
}