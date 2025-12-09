<?php

namespace Controller;

use Service\TeamService;
use Error\APIException;

class TeamController {
    private TeamService $teamService;

    public function __construct() {
        $this->teamService = new TeamService();
    }

    // GET /teams
    public function getAllTeams(?string $name = null) {
        try {
            $teams = $this->teamService->getAllTeams($name);
            echo json_encode($teams);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // GET /teams/{id}
    public function getTeamById(int $id) {
        try {
            $team = $this->teamService->getTeamById($id);
            echo json_encode($team);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // POST /teams
    public function createTeam(string $name, float $gold) {
        try {
            $team = $this->teamService->createTeam($name, $gold);
            echo json_encode($team);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // PUT /teams/{id}
    public function updateTeam(int $id, string $name, float $gold) {
        try {
            $team = $this->teamService->updateTeam($id, $name, $gold);
            echo json_encode($team);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // DELETE /teams/{id}
    public function deleteTeam(int $id) {
        try {
            $this->teamService->deleteTeam($id);
            echo json_encode(['message' => 'Team deletada com sucesso']);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // GET /teams/{id}/members
    public function getMembersByTeam(int $teamId) {
        try {
            $members = $this->teamService->getMembersByTeam($teamId);
            echo json_encode($members);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // PATCH /teams/:id/gold
    public function updateGold(int $teamId, int $addAmount) {
        try {
            $team = $this->teamService->updateGold($teamId, $addAmount);
            echo json_encode($team);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // POST /teams/:team_id/missions
    public function addMission(int $teamId, int $missionId) {
        try {
            $this->teamService->addMissionToTeam($teamId, $missionId);
            echo json_encode(['message' => 'Missão adicionada ao time']);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // GET /teams/:team_id/missions
    public function getMissions(int $teamId) {
        try {
            $missions = $this->teamService->getMissions($teamId);
            echo json_encode($missions);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // GET /teams/:team_id/missions/:mission_id
    public function getMissionById(int $teamId, int $missionId) {
        try {
            $mission = $this->teamService->getMissionById($teamId, $missionId);
            echo json_encode($mission);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // DELETE /teams/:team_id/missions/:mission_id
    public function removeMission(int $teamId, int $missionId) {
        try {
            $this->teamService->removeMissionFromTeam($teamId, $missionId);
            echo json_encode(['message' => 'Missão removida do time']);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }


}
