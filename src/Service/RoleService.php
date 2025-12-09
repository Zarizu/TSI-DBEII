<?php

namespace Service;

use Error\APIException;
use Model\Role;
use Repository\RoleRepository;

class RoleService {
    private RoleRepository $roleRepository;

    public function __construct() {
        $this->roleRepository = new RoleRepository();
    }

    public function createRole(string $name): Role {
        $name = trim($name);
        if (strlen($name) < 2) {
            throw new APIException("Nome da role inválido", 400);
        }

        // Verifica se já existe
        $existingRoles = $this->roleRepository->findByName($name);
        if (count($existingRoles) > 0) {
            throw new APIException("Role já existe", 400);
        }

        $role = new Role(name: $name);
        return $this->roleRepository->create($role);
    }

    public function getRoleById(int $id): Role {
        $role = $this->roleRepository->findById($id);
        if (!$role) {
            throw new APIException("Role não encontrada", 404);
        }
        return $role;
    }

    public function getAllRoles(): array {
        return $this->roleRepository->findAll();
    }

    public function updateRole(int $id, string $name): Role {
        $role = $this->getRoleById($id);

        $name = trim($name);
        if (strlen($name) < 2) {
            throw new APIException("Nome da role inválido", 400);
        }

        $role->setName($name);
        $this->roleRepository->update($role);

        return $role;
    }

    public function deleteRole(int $id): void {
        $role = $this->getRoleById($id);
        $this->roleRepository->delete($id);
    }

}
