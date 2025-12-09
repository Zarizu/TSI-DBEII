<?php

namespace Controller;

use Service\MissionService;
use Error\APIException;

class MissionController {
    private MissionService $missionService;

    public function __construct() {
        $this->missionService = new MissionService();
    }

    // GET /missions
    public function getAllMissions(?string $name = null) {
        try {
            $missions = $this->missionService->getAllMissions($name);
            echo json_encode($missions);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // GET /missions/{id}
    public function getMissionById(int $id) {
        try {
            $mission = $this->missionService->getMissionById($id);
            echo json_encode($mission);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // POST /missions
    public function createMission(string $name, string $description, float $reward) {
        try {
            $mission = $this->missionService->createMission($name, $description, $reward);
            echo json_encode($mission);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // PUT /missions/{id}
    public function updateMission(int $id, string $name, string $description, float $reward) {
        try {
            $mission = $this->missionService->updateMission($id, $name, $description, $reward);
            echo json_encode($mission);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // DELETE /missions/{id}
    public function deleteMission(int $id) {
        try {
            $this->missionService->deleteMission($id);
            echo json_encode(['message' => 'Mission deletada com sucesso']);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // GET /missions/{id}/teams
    public function getTeamsByMission(int $missionId) {
        try {
            $teams = $this->missionService->getTeamsByMission($missionId);
            echo json_encode($teams);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // PATCH /missions/:id/reward
    public function updateReward(int $missionId, float $reward) {
        try {
            $mission = $this->missionService->updateReward($missionId, $reward);
            echo json_encode($mission);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

}
