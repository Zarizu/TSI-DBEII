<?php

namespace Controller;

use Service\RoleService;
use Error\APIException;

class RoleController {
    private RoleService $roleService;

    public function __construct() {
        $this->roleService = new RoleService();
    }

    // GET /roles
    public function getAllRoles(?string $name = null) {
        try {
            $roles = $this->roleService->getAllRoles($name);
            echo json_encode($roles);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // GET /roles/{id}
    public function getRoleById(int $id) {
        try {
            $role = $this->roleService->getRoleById($id);
            echo json_encode($role);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // POST /roles
    public function createRole(string $name) {
        try {
            $role = $this->roleService->createRole($name);
            echo json_encode($role);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // PUT /roles/{id}
    public function updateRole(int $id, string $name) {
        try {
            $role = $this->roleService->updateRole($id, $name);
            echo json_encode($role);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // DELETE /roles/{id}
    public function deleteRole(int $id) {
        try {
            $this->roleService->deleteRole($id);
            echo json_encode(['message' => 'Role deletada com sucesso']);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // GET /roles/{id}/members
    public function getMembersByRole(int $roleId) {
        try {
            $members = $this->roleService->getMembersByRole($roleId);
            echo json_encode($members);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
