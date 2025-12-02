<?php

namespace Repository;

use Database\Database;
use Model\Mission;
use Model\Team;
use PDO;

class MissionRepository {
    private $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function findAll(): array {
        $stmt = $this->connection->prepare("SELECT * FROM missions");
        $stmt->execute();

        $missions = [];
        while ($row = $stmt->fetch()) {
            $mission = new Mission(
                id: $row['id'],
                name: $row['name'],
                description: $row['description'],
                reward: $row['reward'],
            );
            $missions[] = $mission;
        }

        return $missions;
    }

    public function getTeams(): array {
        $stmt = $this->connection->prepare("SELECT * FROM team_mission WHERE mission_id = :mission_id");
        $stmt->execute();

        $missions = [];
        while ($row = $stmt->fetch()) {
            $mission = new Team(
                id: $row['id'],
                name: $row['name'],
                gold: $row['gold'],
            );
            $missions[] = $mission;
        }

        return $missions;
    }

    public function findByName(string $name): array {
        $stmt = $this->connection->prepare("SELECT * FROM courses WHERE name like :name");
        $stmt->bindValue(':name', '%' . $name . '%');
        $stmt->execute();

        $missions = [];
        while ($row = $stmt->fetch()) {
            $mission = new Mission(
                id: $row['id'],
                name: $row['name'],
                description: $row['description'],
                reward: $row['reward'],
            );
            $missions[] = $mission;
        }

        return $missions;
    }

    public function findById(int $id): ?Mission {
        $stmt = $this->connection->prepare("SELECT * FROM missions WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();
        if (!$row) return null;

        $mission = new Mission(
            id: $row['id'],
            name: $row['name'],
            description: $row['description'],
            reward: $row['reward'],
        );

        return $mission;
    }

    public function create(Mission $mission): Mission {
        $stmt = $this->connection->prepare("INSERT INTO missions (name, description, reward) VALUES (:name, :description, :reward)");
        $stmt->bindValue(':name', $mission->getName());
        $stmt->bindValue(':description', $mission->getDescription(), PDO::PARAM_FLOAT);
        $stmt->bindValue(':reward', $mission->getReward(), PDO::PARAM_INT);
        $stmt->execute();

        $mission->setId($this->connection->lastInsertId());

        return $mission;
    }

    public function update(Mission $mission): void {
        $stmt = $this->connection->prepare("UPDATE missions SET name = :name, description = :description, reward = :reward WHERE id = :id;");
        $stmt->bindValue(':id', $mission->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $mission->getName());
        $stmt->bindValue(':description', $mission->getDescription(), PDO::PARAM_FLOAT);
        $stmt->bindValue(':reward', $mission->getReward(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete(int $id): void {
        $stmt = $this->connection->prepare("DELETE FROM missions WHERE id = :id;");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}