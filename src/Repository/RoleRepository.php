<?php

namespace Repository;

use Database\Database;
use Model\Member;
use PDO;

class MemberRepository {
    private $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function findAll(): array {
        $stmt = $this->connection->prepare("SELECT * FROM members");
        $stmt->execute();

        $members = [];
        while ($row = $stmt->fetch()) {
            $member = new Member(
                id: $row['id'],
                name: $row['name'],
                role: $row['role'],
                gold: $row['gold'],
                team: $row['team'],
            );
            $members[] = $member;
        }

        return $members;
    }

    public function findByName(string $name): array {
        $stmt = $this->connection->prepare("SELECT * FROM courses WHERE name like :name");
        $stmt->bindValue(':name', '%' . $name . '%');
        $stmt->execute();

        $members = [];
        while ($row = $stmt->fetch()) {
            $member = new Member(
                id: $row['id'],
                name: $row['name'],
                role: $row['role'],
                gold: $row['gold'],
                team: $row['team'],
            );
            $members[] = $member;
        }

        return $members;
    }

    public function findById(int $id): ?Member {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();
        if (!$row) return null;

        $member = new Member(
            id: $row['id'],
            name: $row['name'],
            role: $row['role'],
            gold: $row['gold'],
            team: $row['team'],
        );

        return $member;
    }

    public function create(Member $member): Member {
        $stmt = $this->connection->prepare("INSERT INTO members (name, role, gold, team) VALUES (:name, :role, :gold, :team)");
        $stmt->bindValue(':name', $member->getName());
        $stmt->bindValue(':role', $member->getRole(), PDO::PARAM_INT);
        $stmt->bindValue(':gold', $member->getGold(), PDO::PARAM_FLOAT);
        $stmt->bindValue(':team', $member->getTeam(), PDO::PARAM_INT);
        $stmt->execute();

        $member->setId($this->connection->lastInsertId());

        return $member;
    }

    public function update(Member $member): void {
        $stmt = $this->connection->prepare("UPDATE members SET name = :name, role = :role, gold = :gold, team = :team WHERE id = :id;");
        $stmt->bindValue(':id', $member->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $member->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':role', $member->getRole(), PDO::PARAM_INT);
        $stmt->bindValue(':gold', $member->getGold(), PDO::PARAM_FLOAT);
        $stmt->bindValue(':team', $member->getTeam(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete(int $id): void {
        $stmt = $this->connection->prepare("DELETE FROM member WHERE id = :id;");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}