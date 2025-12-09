<?php

namespace Repository;

use Database\Database;
use Model\Team;
use PDO;

class TeamRepository {
    private PDO $connection;
    private TeamMissionRepository $teamMissionRepository;

    public function __construct() {
        $this->connection = Database::getConnection();
        $this->teamMissionRepository = new TeamMissionRepository();
    }

    public function findAll(): array {
        $stmt = $this->connection->prepare("SELECT * FROM teams");
        $stmt->execute();

        $teams = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $teams[] = new Team(
                id: $row['id'],
                name: $row['name'],
                gold: $row['gold']
            );
        }

        return $teams;
    }

    public function findById(int $id): ?Team {
        $stmt = $this->connection->prepare("SELECT * FROM teams WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        return new Team(
            id: $row['id'],
            name: $row['name'],
            gold: $row['gold']
        );
    }

    public function create(Team $team): Team {
        $stmt = $this->connection->prepare(
            "INSERT INTO teams (name, gold) VALUES (:name, :gold)"
        );
        $stmt->bindValue(':name', $team->getName());
        $stmt->bindValue(':gold', $team->getGold(), PDO::PARAM_INT);
        $stmt->execute();

        $team->setId($this->connection->lastInsertId());
        return $team;
    }

    public function update(Team $team): void {
        $stmt = $this->connection->prepare(
            "UPDATE teams SET name = :name, gold = :gold WHERE id = :id"
        );
        $stmt->bindValue(':id', $team->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $team->getName());
        $stmt->bindValue(':gold', $team->getGold(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete(int $id): void {
        $stmt = $this->connection->prepare("DELETE FROM teams WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getMissions(int $teamId): array {
        return $this->teamMissionRepository->findMissionsByTeamId($teamId);
    }
}
