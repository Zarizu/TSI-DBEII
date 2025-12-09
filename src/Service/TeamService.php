<?php

namespace Service;

use Error\APIException;
use Model\Team;
use Repository\TeamRepository;
use Repository\MissionRepository;
use Repository\TeamMissionRepository;

class TeamService {
    private TeamRepository $teamRepository;
    private MissionRepository $missionRepository;
    private TeamMissionRepository $teamMissionRepository;

    public function __construct() {
        $this->teamRepository = new TeamRepository();
        $this->missionRepository = new MissionRepository();
        $this->teamMissionRepository = new TeamMissionRepository();
    }

    public function createTeam(string $name, int $gold): Team {
        if (strlen(trim($name)) < 3) {
            throw new APIException("Nome do time inválido", 400);
        }
        if ($gold < 0) {
            throw new APIException("Gold não pode ser negativo", 400);
        }

        $team = new Team(name: $name, gold: $gold);
        return $this->teamRepository->create($team);
    }

    public function assignTeamToMission(int $teamId, int $missionId): void {
        $team = $this->teamRepository->findById($teamId);
        if (!$team) throw new APIException("Time não encontrado", 404);

        $mission = $this->missionRepository->findById($missionId);
        if (!$mission) throw new APIException("Missão não encontrada", 404);

        $this->teamMissionRepository->addTeamToMission($teamId, $missionId);
    }

    public function removeTeamFromMission(int $teamId, int $missionId): void {
        $this->teamMissionRepository->removeTeamFromMission($teamId, $missionId);
    }

    public function getTeamMissions(int $teamId): array {
        return $this->teamRepository->getMissions($teamId);
    }
}
