<?php

namespace Service;

use Error\APIException;
use Model\Mission;
use Repository\MissionRepository;
use Repository\TeamRepository;
use Repository\TeamMissionRepository;

class MissionService {
    private MissionRepository $missionRepository;
    private TeamRepository $teamRepository;
    private TeamMissionRepository $teamMissionRepository;

    public function __construct() {
        $this->missionRepository = new MissionRepository();
        $this->teamRepository = new TeamRepository();
        $this->teamMissionRepository = new TeamMissionRepository();
    }

    public function createMission(string $name, string $description, int $reward): Mission {
        if (strlen(trim($name)) < 3) throw new APIException("Nome da missão inválido", 400);
        if ($reward < 0) throw new APIException("Recompensa inválida", 400);

        $mission = new Mission(name: $name, description: $description, reward: $reward);
        return $this->missionRepository->create($mission);
    }

    public function getMissionTeams(int $missionId): array {
        return $this->missionRepository->getTeams($missionId);
    }
}
