<?php

namespace Repository;

use Database\Database;
use Model\Role;
use PDO;

class RoleRepository {
    private PDO $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function findAll(): array {
        $stmt = $this->connection->prepare("SELECT * FROM roles");
        $stmt->execute();

        $roles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $roles[] = new Role(
                id: $row['id'],
                name: $row['name']
            );
        }

        return $roles;
    }

    public function findByName(string $name): array {
        $stmt = $this->connection->prepare(
            "SELECT * FROM roles WHERE name LIKE :name"
        );
        $stmt->bindValue(':name', '%' . $name . '%');
        $stmt->execute();

        $roles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $roles[] = new Role(
                id: $row['id'],
                name: $row['name']
            );
        }

        return $roles;
    }

    public function findById(int $id): ?Role {
        $stmt = $this->connection->prepare("SELECT * FROM roles WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Role(
            id: $row['id'],
            name: $row['name']
        );
    }

    public function create(Role $role): Role {
        $stmt = $this->connection->prepare(
            "INSERT INTO roles (name) VALUES (:name)"
        );

        $stmt->bindValue(':name', $role->getName(), PDO::PARAM_STR);
        $stmt->execute();

        $role->setId($this->connection->lastInsertId());

        return $role;
    }

    public function update(Role $role): void {
        $stmt = $this->connection->prepare(
            "UPDATE roles SET name = :name WHERE id = :id"
        );

        $stmt->bindValue(':id', $role->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $role->getName(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function delete(int $id): void {
        $stmt = $this->connection->prepare(
            "DELETE FROM roles WHERE id = :id"
        );

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
