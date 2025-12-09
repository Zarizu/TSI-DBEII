<?php

namespace Repository;

use Database\Database;
use Model\Mission;
use PDO;

class MissionRepository {
    private PDO $connection;
    private TeamMissionRepository $teamMissionRepository;

    public function __construct() {
        $this->connection = Database::getConnection();
        $this->teamMissionRepository = new TeamMissionRepository();
    }

    public function findAll(): array {
        $stmt = $this->connection->prepare("SELECT * FROM missions");
        $stmt->execute();

        $missions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $missions[] = new Mission(
                id: $row['id'],
                name: $row['name'],
                description: $row['description'],
                reward: $row['reward']
            );
        }

        return $missions;
    }

    public function findById(int $id): ?Mission {
        $stmt = $this->connection->prepare("SELECT * FROM missions WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        return new Mission(
            id: $row['id'],
            name: $row['name'],
            description: $row['description'],
            reward: $row['reward']
        );
    }

    public function create(Mission $mission): Mission {
        $stmt = $this->connection->prepare(
            "INSERT INTO missions (name, description, reward) VALUES (:name, :description, :reward)"
        );
        $stmt->bindValue(':name', $mission->getName());
        $stmt->bindValue(':description', $mission->getDescription());
        $stmt->bindValue(':reward', $mission->getReward(), PDO::PARAM_INT);
        $stmt->execute();

        $mission->setId($this->connection->lastInsertId());
        return $mission;
    }

    public function update(Mission $mission): void {
        $stmt = $this->connection->prepare(
            "UPDATE missions SET name = :name, description = :description, reward = :reward WHERE id = :id"
        );
        $stmt->bindValue(':id', $mission->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $mission->getName());
        $stmt->bindValue(':description', $mission->getDescription());
        $stmt->bindValue(':reward', $mission->getReward(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete(int $id): void {
        $stmt = $this->connection->prepare("DELETE FROM missions WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // ---------------- Many-to-Many Teams ----------------

    public function getTeams(int $missionId): array {
        return $this->teamMissionRepository->findTeamsByMissionId($missionId);
    }
}
