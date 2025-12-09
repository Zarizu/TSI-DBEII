<?php

namespace Controller;

use Service\MemberService;
use Error\APIException;

class MemberController {
    private MemberService $service;

    public function __construct() {
        $this->service = new MemberService();
    }

    // GET /members
    public function getAll() {
        try {
            $members = $this->service->getAllMembers();
            echo json_encode($members);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // GET /members/{id}
    public function getById(int $id) {
        try {
            $member = $this->service->getMemberById($id);
            echo json_encode($member);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // GET /members/:id/inventory
    public function getInventory(int $memberId) {
        try {
            $items = $this->memberService->getInventory($memberId);
            echo json_encode($items);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // PATCH /members/:id/gold
    public function updateGold(int $memberId, int $addAmount) {
        try {
            $member = $this->memberService->updateGold($memberId, $addAmount);
            echo json_encode($member);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

}
