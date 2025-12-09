<?php

namespace Repository;

use Database\Database;
use Model\Member;
use PDO;

class MemberRepository {
    private PDO $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function findAll(): array {
        $stmt = $this->connection->prepare("SELECT * FROM members");
        $stmt->execute();

        $members = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $members[] = new Member(
                id: $row['id'],
                name: $row['name'],
                role: $row['role'],
                gold: $row['gold'],
                team: $row['team']
            );
        }

        return $members;
    }

    public function findByName(string $name): array {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE name LIKE :name");
        $stmt->bindValue(':name', '%' . $name . '%');
        $stmt->execute();

        $members = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $members[] = new Member(
                id: $row['id'],
                name: $row['name'],
                role: $row['role'],
                gold: $row['gold'],
                team: $row['team']
            );
        }

        return $members;
    }

    public function findById(int $id): ?Member {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        return new Member(
            id: $row['id'],
            name: $row['name'],
            role: $row['role'],
            gold: $row['gold'],
            team: $row['team']
        );
    }

    public function create(Member $member): Member {
        $stmt = $this->connection->prepare(
            "INSERT INTO members (name, role, gold, team) 
             VALUES (:name, :role, :gold, :team)"
        );

        $stmt->bindValue(':name', $member->getName());
        $stmt->bindValue(':role', $member->getRole(), PDO::PARAM_INT);
        $stmt->bindValue(':gold', $member->getGold(), PDO::PARAM_STR);
        $stmt->bindValue(':team', $member->getTeam(), PDO::PARAM_INT);
        $stmt->execute();

        $member->setId($this->connection->lastInsertId());

        return $member;
    }

    public function update(Member $member): void {
        $stmt = $this->connection->prepare(
            "UPDATE members
             SET name = :name, role = :role, gold = :gold, team = :team
             WHERE id = :id"
        );

        $stmt->bindValue(':id', $member->getId(), PDO::PARAM_INT);
<<<<<<< Updated upstream:src/Repository/RoleRepository.php
        $stmt->bindValue(':name', $member->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':role', $member->getRole(), PDO::PARAM_INT);
        $stmt->bindValue(':gold', $member->getGold(), PDO::PARAM_FLOAT);
=======
        $stmt->bindValue(':name', $member->getName());
        $stmt->bindValue(':role', $member->getRole(), PDO::PARAM_INT);
        $stmt->bindValue(':gold', $member->getGold(), PDO::PARAM_STR);
>>>>>>> Stashed changes:src/Repository/MemberRepositoty.php
        $stmt->bindValue(':team', $member->getTeam(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete(int $id): void {
        $stmt = $this->connection->prepare("DELETE FROM members WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getRoleByMemberId(int $memberId): ?array {
        $stmt = $this->connection->prepare("
            SELECT r.* 
            FROM roles r
            JOIN members m ON m.role = r.id
            WHERE m.id = :id
        ");
        $stmt->bindValue(':id', $memberId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function getRoleId(int $memberId): ?int {
        $stmt = $this->connection->prepare("SELECT role FROM members WHERE id = :id");
        $stmt->bindValue(':id', $memberId, PDO::PARAM_INT);
        $stmt->execute();

        $value = $stmt->fetchColumn();
        return $value !== false ? (int)$value : null;
    }

    public function findByRoleId(int $roleId): array {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE role = :role");
        $stmt->bindValue(':role', $roleId, PDO::PARAM_INT);
        $stmt->execute();

        $members = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $members[] = new Member(
                id: $row['id'],
                name: $row['name'],
                role: $row['role'],
                gold: $row['gold'],
                team: $row['team']
            );
        }

        return $members;
    }

    public function findByRoleIdAndName(int $roleId, string $name): array {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE role = :role AND name LIKE :name");
        $stmt->bindValue(':role', $roleId, PDO::PARAM_INT);
        $stmt->bindValue(':name', '%' . $name . '%');
        $stmt->execute();

        $members = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $members[] = new Member(
                id: $row['id'],
                name: $row['name'],
                role: $row['role'],
                gold: $row['gold'],
                team: $row['team']
            );
        }

        return $members;
    }

    public function findByRoleIdAndMemberId(int $roleId, int $memberId): ?Member {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE role = :role AND id = :id");
        $stmt->bindValue(':role', $roleId, PDO::PARAM_INT);
        $stmt->bindValue(':id', $memberId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        return new Member(
            id: $row['id'],
            name: $row['name'],
            role: $row['role'],
            gold: $row['gold'],
            team: $row['team']
        );
    }

    public function findByTeamId(int $teamId): array {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE team = :team");
        $stmt->bindValue(':team', $teamId, PDO::PARAM_INT);
        $stmt->execute();

        $members = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $members[] = new Member(
                id: $row['id'],
                name: $row['name'],
                role: $row['role'],
                gold: $row['gold'],
                team: $row['team']
            );
        }

        return $members;
    }

    public function findByTeamIdAndName(int $teamId, string $name): array {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE team = :team AND name LIKE :name");
        $stmt->bindValue(':team', $teamId, PDO::PARAM_INT);
        $stmt->bindValue(':name', '%' . $name . '%');
        $stmt->execute();

        $members = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $members[] = new Member(
                id: $row['id'],
                name: $row['name'],
                role: $row['role'],
                gold: $row['gold'],
                team: $row['team']
            );
        }

        return $members;
    }

    public function findByTeamIdAndMemberId(int $teamId, int $memberId): ?Member {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE team = :team AND id = :id");
        $stmt->bindValue(':team', $teamId, PDO::PARAM_INT);
        $stmt->bindValue(':id', $memberId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        return new Member(
            id: $row['id'],
            name: $row['name'],
            role: $row['role'],
            gold: $row['gold'],
            team: $row['team']
        );
    }
}
