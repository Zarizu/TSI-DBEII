<?php

namespace Repository;

use Database\Database;
use PDO;

class TeamMissionRepository {
    private PDO $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function addTeamToMission(int $teamId, int $missionId): void {
        $stmt = $this->connection->prepare(
            "INSERT IGNORE INTO team_mission (team_id, mission_id) VALUES (:team_id, :mission_id)"
        );
        $stmt->bindValue(':team_id', $teamId, PDO::PARAM_INT);
        $stmt->bindValue(':mission_id', $missionId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function removeTeamFromMission(int $teamId, int $missionId): void {
        $stmt = $this->connection->prepare(
            "DELETE FROM team_mission WHERE team_id = :team_id AND mission_id = :mission_id"
        );
        $stmt->bindValue(':team_id', $teamId, PDO::PARAM_INT);
        $stmt->bindValue(':mission_id', $missionId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function findMissionsByTeamId(int $teamId): array {
        $stmt = $this->connection->prepare(
            "SELECT m.* FROM missions m
             JOIN team_mission tm ON tm.mission_id = m.id
             WHERE tm.team_id = :team_id"
        );
        $stmt->bindValue(':team_id', $teamId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findTeamsByMissionId(int $missionId): array {
        $stmt = $this->connection->prepare(
            "SELECT t.* FROM teams t
             JOIN team_mission tm ON tm.team_id = t.id
             WHERE tm.mission_id = :mission_id"
        );
        $stmt->bindValue(':mission_id', $missionId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
