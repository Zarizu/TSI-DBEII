<?php

namespace Service;

use Error\APIException;
use Model\Item;
use Repository\ItemRepository;
use Repository\MemberRepository;

class ItemService {
    private ItemRepository $itemRepository;
    private MemberRepository $memberRepository;

    public function __construct() {
        $this->itemRepository = new ItemRepository();
        $this->memberRepository = new MemberRepository();
    }

    public function createItem(string $name, int $amount, int $ownerId): Item {
        $name = trim($name);
        if (strlen($name) < 2) {
            throw new APIException("Nome do item inválido", 400);
        }

        if ($amount < 0) {
            throw new APIException("Quantidade inválida", 400);
        }

        $owner = $this->memberRepository->findById($ownerId);
        if (!$owner) {
            throw new APIException("Owner (Member) não encontrado", 404);
        }

        $item = new Item(
            name: $name,
            amount: $amount,
            owner: $ownerId
        );

        return $this->itemRepository->create($item);
    }

    public function getItemById(int $id): Item {
        $item = $this->itemRepository->findById($id);
        if (!$item) throw new APIException("Item não encontrado", 404);
        return $item;
    }

    public function getAllItems(?string $name = null): array {
        if ($name) {
            return $this->itemRepository->findByName($name);
        }
        return $this->itemRepository->findAll();
    }

    public function updateItem(int $id, string $name, int $amount, int $ownerId): Item {
        $item = $this->getItemById($id);

        $name = trim($name);
        if (strlen($name) < 2) throw new APIException("Nome do item inválido", 400);
        if ($amount < 0) throw new APIException("Quantidade inválida", 400);

        $owner = $this->memberRepository->findById($ownerId);
        if (!$owner) throw new APIException("Owner (Member) não encontrado", 404);

        $item->setName($name);
        $item->setAmount($amount);
        $item->setOwner($ownerId);

        $this->itemRepository->update($item);

        return $item;
    }

    public function deleteItem(int $id): void {
        $this->getItemById($id);
        $this->itemRepository->delete($id);
    }

    public function getItemsByOwner(int $ownerId): array {
        $owner = $this->memberRepository->findById($ownerId);
        if (!$owner) throw new APIException("Owner (Member) não encontrado", 404);

        return $this->itemRepository->findByOwner($ownerId);
    }

    public function transferItem(int $itemId, int $newOwnerId): Item {
        $item = $this->itemRepository->findById($itemId);
        if (!$item) throw new APIException("Item não encontrado", 404);

        $newOwner = $this->memberRepository->findById($newOwnerId);
        if (!$newOwner) throw new APIException("Novo dono não encontrado", 404);

        $item->setOwner($newOwnerId);

        $this->itemRepository->update($item);

        return $item;
    }
}
