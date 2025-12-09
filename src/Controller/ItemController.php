<?php

namespace Controller;

use Service\ItemService;
use Error\APIException;

class ItemController {
    private ItemService $itemService;

    public function __construct() {
        $this->itemService = new ItemService();
    }

    // GET /items
    public function getAllItems(?string $name = null) {
        try {
            $items = $this->itemService->getAllItems($name);
            echo json_encode($items);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // GET /items/{id}
    public function getItemById(int $id) {
        try {
            $item = $this->itemService->getItemById($id);
            echo json_encode($item);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // POST /items
    public function createItem(string $name, int $amount, int $owner) {
        try {
            $item = $this->itemService->createItem($name, $amount, $owner);
            echo json_encode($item);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // PUT /items/{id}
    public function updateItem(int $id, string $name, int $amount, int $owner) {
        try {
            $item = $this->itemService->updateItem($id, $name, $amount, $owner);
            echo json_encode($item);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // DELETE /items/{id}
    public function deleteItem(int $id) {
        try {
            $this->itemService->deleteItem($id);
            echo json_encode(['message' => 'Item deletado com sucesso']);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // GET /items/owner/{ownerId}
    public function getItemsByOwner(int $ownerId) {
        try {
            $items = $this->itemService->getItemsByOwner($ownerId);
            echo json_encode($items);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // PATCH /items/:id/amount
    public function updateAmount(int $itemId, int $amount) {
        try {
            $item = $this->itemService->updateAmount($itemId, $amount);
            echo json_encode($item);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // PATCH /items/:member_id/transfer
    public function transferItem(int $itemId, int $newOwnerId) {
        try {
            $item = $this->itemService->transferItem($itemId, $newOwnerId);
            echo json_encode($item);
        } catch (APIException $e) {
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }


}
