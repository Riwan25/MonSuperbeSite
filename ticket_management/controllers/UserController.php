<?php

require_once __DIR__ . '/../DAO/UserDAO.php';
class UserController {
    public static function getUser(string $email){
        $data = UserDAO::getUser($email);
        var_dump($data);
        if(!$data) return null;
        return new User(
            $data['email'],
            $data['role_id'],
            $data['leader_id'],
            $data['id'],
            $data['role_name'],
            $data['password']
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

    static function login($email, $pwd){
        $user = self::getUser($email);

        if($user === null){
            $_SESSION['error'] = "Invalid credentials";
            return null;
        }

        $pwd_hashed = $user->getPassword();

        if (!password_verify($pwd, $pwd_hashed)) {
            $_SESSION['error'] = "Invalid credentials";
            return null;
        }

        return $user;
    }

    static function register($email, $password, $roleId = 1, $leaderId = null){
        // Check if user already exists
        $existingUser = self::getUser($email);
        if($existingUser !== null){
            $_SESSION['error'] = "An account with this email already exists";
            return false;
        }

        // Create new user
        $user = new User($email, $roleId, $leaderId, null, null, $password);
        $result = UserDAO::createUser($user);

        if(!$result){
            $_SESSION['error'] = "Error creating account";
            return false;
        }

        return true;
    }
}