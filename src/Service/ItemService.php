<?php

namespace Service;

use Error\APIException;
use Model\Member;
use Repository\RoleRepository;
use Repository\TeamRepository;
use Repository\MemberRepository;

class MemberService {
    private MemberRepository $repository;
    private RoleRepository $roleRepository;
    private TeamRepository $teamRepository;

    public function __construct() {
        $this->repository = new MemberRepository();
        $this->roleRepository = new RoleRepository();
        $this->teamRepository = new TeamRepository();
    }

    public function getMembers(?string $name): array {
        if ($name) return $this->repository->findByName($name);

        return $this->repository->findAll();
    }

    public function getMemberById(string $id): Member {
        $member = $this->repository->findById((int)$id);

        if (!$member) throw new APIException("Member not found!", 404);

        return $member;
    }

    public function createNewMember(
        string $name,
        int $roleId,
        float $gold,
        int $teamId
    ): Member {

        $member = new Member(
            name: $name,
            role: $roleId,
            gold: $gold,
            team: $teamId
        );

        $this->validateMember($member);

        return $this->repository->create($member);
    }

    public function updateMember(
        string $id,
        string $name,
        int $roleId,
        float $gold,
        int $teamId
    ): Member {

        $member = $this->getMemberById($id);

        $member->setName($name);
        $member->setRole($roleId);
        $member->setGold($gold);
        $member->setTeam($teamId);

        $this->validateMember($member);

        $this->repository->update($member);

        return $member;
    }

    public function deleteMember(string $id): void {
        $member = $this->getMemberById($id);
        $this->repository->delete((int)$id);
    }

    private function validateMember(Member $member): void {
        if (strlen(trim($member->getName())) < 2)
            throw new APIException("Invalid member name!", 400);

        // validar existência da role
        $roleId = $member->getRole();
        $role = $this->roleRepository->findById($roleId);
        if (!$role)
            throw new APIException("Role not found!", 404);

        // validar existência da team
        $teamId = $member->getTeam();
        $team = $this->teamRepository->findById($teamId);
        if (!$team)
            throw new APIException("Team not found!", 404);
    }
}
