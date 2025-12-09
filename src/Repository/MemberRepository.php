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

<<<<<<< Updated upstream:src/Repository/MemberRepository.php
    public function findByRole(int $roleID): ?Member {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE role = :role");
        $stmt->bindValue(':role', $roleID, PDO::PARAM_INT);
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

    public function findByTeam(int $teamID): ?Member {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE team = :team");
        $stmt->bindValue(':team', $teamID, PDO::PARAM_INT);
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
=======
    public function create(Mission $mission): Mission {
        $stmt = $this->connection->prepare(
            "INSERT INTO missions (name, description, reward) VALUES (:name, :description, :reward)"
        );
        $stmt->bindValue(':name', $mission->getName());
        $stmt->bindValue(':description', $mission->getDescription());
        $stmt->bindValue(':reward', $mission->getReward(), PDO::PARAM_INT);
>>>>>>> Stashed changes:src/Repository/MissionRepositoty.php
        $stmt->execute();

        $mission->setId($this->connection->lastInsertId());
        return $mission;
    }

<<<<<<< Updated upstream:src/Repository/MemberRepository.php
    public function update(Member $member): void {
        $stmt = $this->connection->prepare("UPDATE members SET name = :name, role = :role, gold = :gold, team = :team WHERE id = :id;");
        $stmt->bindValue(':id', $member->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $member->getName());
        $stmt->bindValue(':role', $member->getRole(), PDO::PARAM_INT);
        $stmt->bindValue(':gold', $member->getGold(), PDO::PARAM_FLOAT);
        $stmt->bindValue(':team', $member->getTeam(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateGold(int $id, float $gold): void {
        $stmt = $this->connection->prepare("UPDATE members SET gold = :gold WHERE id = :id;");
        $stmt->bindValue(':id', $team->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':gold', $team->getGold(), PDO::PARAM_FLOAT);
=======
    public function update(Mission $mission): void {
        $stmt = $this->connection->prepare(
            "UPDATE missions SET name = :name, description = :description, reward = :reward WHERE id = :id"
        );
        $stmt->bindValue(':id', $mission->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $mission->getName());
        $stmt->bindValue(':description', $mission->getDescription());
        $stmt->bindValue(':reward', $mission->getReward(), PDO::PARAM_INT);
>>>>>>> Stashed changes:src/Repository/MissionRepositoty.php
        $stmt->execute();
    }

    public function delete(int $id): void {
<<<<<<< Updated upstream:src/Repository/MemberRepository.php
        $stmt = $this->connection->prepare("DELETE FROM members WHERE id = :id;");
=======
        $stmt = $this->connection->prepare("DELETE FROM missions WHERE id = :id");
>>>>>>> Stashed changes:src/Repository/MissionRepositoty.php
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getTeams(int $missionId): array {
        return $this->teamMissionRepository->findTeamsByMissionId($missionId);
    }
}
