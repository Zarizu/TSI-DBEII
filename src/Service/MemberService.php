<?php

namespace Service;

use Error\APIException;
use Model\Member;
use Repository\ModelRepository;
use Repository\TeamRepository;

class MemberService {
    private MemberRepository $repository;
    private TeamRepository $teamRepository;

    function __construct() {
        $this->repository = new MemberRepository();
        $this->courseRepository = new CourseRepository();

    }

    function getMembers(?string $name): array {
        if ($name)
            return $this->repository->findByName($name);
        else
            return $this->repository->findAll();
    }

    function getMemberById(string $id): Member {
        $member = $this->repository->findById($id);

        if (!$member)
            throw new APIException("Member not found!", 404);

        return $member;
    }

    function createNewMember(
        string $name,
        string $email,
        int $courseId,
        int $semester
    ): Member {
        $member = new Member(
            name: $name,
            email: $email,
            courseId: $courseId,
            semester: $semester
        );

        $this->validateMember($member);

        return $this->repository->create($member);
    }
    function updateMember(
        string $id,
        string $name,
        string $role,
        int $gold,
        int $team
    ): Member {
        $member = $this->getMemberById($id);

        $member->setName($name);
        $member->setRole($role);
        $member->setGold($gold);
        $member->setTeam($team);

        $this->validateMember($member);
        $this->repository->update($member);

        return $member;
    }

    function deleteMember(string $id)
    {
        //busca o estudante pelo Id para verificar se existe
        $member = $this->getMemberById($id);

        //Exclui o estudante no banco de dados
        $this->repository->delete($id);
    }

    function setMemberSemester(string $id, int $semester): Member
    {
        //busca o estudante pelo Id
        $member = $this->getMemberById($id);

        //atualiza o período do estudante
        $member->setSemester($semester);

        //valida se o estudante atualizado está de acordo com as regras
        $this->validateMember($member);

        //altera o período do estudante
        $this->repository->setSemester($id, $semester);

        //retorna o estudante atualizado
        return $member;
    }

    private function validateMember(Member $member)
    {
        //verifica se o nome do estudante tem pelo menos 5 caracters
        if (strlen(trim($member->getName())) < 5)
            throw new APIException("Invalid Member name!", 400);

        //verificar se o email é válido
        if (!filter_var($member->getEmail(), FILTER_VALIDATE_EMAIL))
            throw new APIException("Invalid email!", 400);

        //verifica se exites um estudante com o mesmo email
        $memberWithSameEmail = $this->repository->findByEmail($member->getEmail());
        if ($memberWithSameEmail) {
            //como pode ser um update, verificar se o email encontrado não é do próprio estudante
            if ($memberWithSameEmail->getId() !== $member->getId())
                throw new APIException("This email is already in use!", 409);
        }

        //verifica se o Id do curso refere-se a um curso existente
        $course = $this->courseRepository->findById($Member->getCourseId());
        if (!$course)
            throw new APIException("Course not found!", 404);

        //verifica se o período do estudante é maior ou igual a zero
        if ($Member->getSemester() <= 0)
            throw new APIException("Semester must be greater than zero!", 400);

        //verifica se o período do estudante não é maior do que o número de períodos do curso
        if ($Member->getSemester() > $course->getSemesters())
            throw new APIException("Semester is greater than course semesters!", 400);
    }
}