<?php

namespace Service;

use Error\APIException;
use Model\Member;
use Repository\MemberRepository;
use Repository\RoleRepository;
use Repository\TeamRepository;

class MemberService {
    private MemberRepository $memberRepository;
    private RoleRepository $roleRepository;
    private TeamRepository $teamRepository;

    public function __construct() {
        $this->memberRepository = new MemberRepository();
        $this->roleRepository = new RoleRepository();
        $this->teamRepository = new TeamRepository();
    }

    public function createMember(string $name, int $roleId, int $teamId, float $gold): Member {
        $name = trim($name);
        if (strlen($name) < 3) {
            throw new APIException("Nome do membro inválido", 400);
        }

        $role = $this->roleRepository->findById($roleId);
        if (!$role) throw new APIException("Role não encontrada", 404);

        $team = $this->teamRepository->findById($teamId);
        if (!$team) throw new APIException("Team não encontrado", 404);

        if ($gold < 0) throw new APIException("Gold não pode ser negativo", 400);

        $member = new Member(
            name: $name,
            role: $roleId,
            team: $teamId,
            gold: $gold
        );

        return $this->memberRepository->create($member);
    }

    public function getMemberById(int $id): Member {
        $member = $this->memberRepository->findById($id);
        if (!$member) throw new APIException("Member não encontrado", 404);
        return $member;
    }

    public function getAllMembers(?string $name = null): array {
        if ($name) {
            return $this->memberRepository->findByName($name);
        }
        return $this->memberRepository->findAll();
    }

    public function updateMember(int $id, string $name, int $roleId, int $teamId, float $gold): Member {
        $member = $this->getMemberById($id);

        $name = trim($name);
        if (strlen($name) < 3) throw new APIException("Nome do membro inválido", 400);

        $role = $this->roleRepository->findById($roleId);
        if (!$role) throw new APIException("Role não encontrada", 404);

        $team = $this->teamRepository->findById($teamId);
        if (!$team) throw new APIException("Team não encontrado", 404);

        if ($gold < 0) throw new APIException("Gold não pode ser negativo", 400);

        $member->setName($name);
        $member->setRole($roleId);
        $member->setTeam($teamId);
        $member->setGold($gold);

        $this->memberRepository->update($member);

        return $member;
    }

    public function deleteMember(int $id): void {
        $this->getMemberById($id);
        $this->memberRepository->delete($id);
    }


    public function getMembersByRole(int $roleId): array {
        return $this->memberRepository->findByRole($roleId);
    }

    public function getMembersByTeam(int $teamId): array {
        return $this->memberRepository->findByTeam($teamId);
    }
}
