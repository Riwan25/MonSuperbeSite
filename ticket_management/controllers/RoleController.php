<?php

require_once __DIR__ . '/../DAO/RoleDAO.php';

class RoleController {
    public static function getRoles() {
        $data = RoleDAO::getRoles();
        $roles = [];
        foreach ($data as $roleData) {
            $roles[] = new Role(
                $roleData['name'],
                $roleData['id']
            );
        }
        return $roles;
    }

    public static function getRoleById(int $id) {
        $data = RoleDAO::getRoleById($id);
        if (!$data) return null;
        return new Role(
            $data['name'],
            $data['id']
        );
    }
}
