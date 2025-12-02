<?php

namespace Repository;

use Database\Database;
use Model\Mission;
use Model\Team;
use PDO;

class TeamRepository {
    private $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function findAll(): array {
        $stmt = $this->connection->prepare("SELECT * FROM teams");
        $stmt->execute();

        $teams = [];
        while ($row = $stmt->fetch()) {
            $team = new Team(
                id: $row['id'],
                name: $row['name'],
                gold: $row['gold'],
            );
            $teams[] = $team;
        }

        return $teams;
    }

    public function getMissions(): array {
        $stmt = $this->connection->prepare("SELECT * FROM team_team WHERE team_id = :team_id");
        $stmt->execute();

        $missions = [];
        while ($row = $stmt->fetch()) {
            $mission = new Mission(
                id: $row['id'],
                name: $row['name'],
                description: $row['description'],
                reward: $row['reward'],
            );
            $missions[] = $team;
        }

        return $missions;
    }

    public function findByName(string $name): array {
        $stmt = $this->connection->prepare("SELECT * FROM courses WHERE name like :name");
        $stmt->bindValue(':name', '%' . $name . '%');
        $stmt->execute();

        $teams = [];
        while ($row = $stmt->fetch()) {
            $team = new Team(
                id: $row['id'],
                name: $row['name'],
                gold: $row['gold'],
            );
            $teams[] = $team;
        }

        return $teams;
    }

    public function findById(int $id): ?team {
        $stmt = $this->connection->prepare("SELECT * FROM teams WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();
        if (!$row) return null;

        $team = new Team(
            id: $row['id'],
            name: $row['name'],
            gold: $row['gold'],
        );

        return $team;
    }

    public function create(Team $team): Team {
        $stmt = $this->connection->prepare("INSERT INTO teams (name, gold) VALUES (:name, :gold)");
        $stmt->bindValue(':name', $team->getName());
        $stmt->bindValue(':gold', $team->getGold(), PDO::PARAM_FLOAT);
        $stmt->execute();

        $team->setId($this->connection->lastInsertId());

        return $team;
    }

    public function update(Team $team): void {
        $stmt = $this->connection->prepare("UPDATE teams SET name = :name, gold = :gold WHERE id = :id;");
        $stmt->bindValue(':id', $team->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $team->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':gold', $team->getGold(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateGold(int $id, float $gold): void {
        $stmt = $this->connection->prepare("UPDATE teams SET gold = :gold WHERE id = :id;");
        $stmt->bindValue(':id', $team->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':gold', $team->getGold(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete(int $id): void {
        $stmt = $this->connection->prepare("DELETE FROM teams WHERE id = :id;");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}