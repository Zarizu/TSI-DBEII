<?php

namespace Repository;

use Database\Database;
use Model\Item;
use PDO;

class ItemRepository {
    private PDO $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function findAll(): array {
        $stmt = $this->connection->prepare("SELECT * FROM items");
        $stmt->execute();

        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item(
                id: $row['id'],
                name: $row['name'],
                amount: $row['amount'],
                owner: $row['owner']
            );
        }

        return $items;
    }

    public function findByName(string $name): array {
        $stmt = $this->connection->prepare("SELECT * FROM items WHERE name like :name");
        $stmt->bindValue(':name', '%' . $name . '%');
        $stmt->execute();

        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item(
                id: $row['id'],
                name: $row['name'],
                amount: $row['amount'],
                owner: $row['owner']
            );
        }

        return $items;
    }

    public function findByOwner(string $owner): array {
        $stmt = $this->connection->prepare("SELECT * FROM items WHERE owner = :owner");
        $stmt->bindValue(':owner', $owner);
        $stmt->execute();

        $items = [];
        while ($row = $stmt->fetch()) {
            $item = new Item(
                id: $row['id'],
                name: $row['name'],
                amount: $row['amount'],
                owner: $row['owner'],
            );
            $items[] = $item;
        }

        return $items;
    }

    public function findById(int $id): ?Item {
        $stmt = $this->connection->prepare("SELECT * FROM items WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        return new Item(
            id: $row['id'],
            name: $row['name'],
            amount: $row['amount'],
            owner: $row['owner']
        );
    }

    public function create(Item $item): Item {
        $stmt = $this->connection->prepare(
            "INSERT INTO items (name, amount, owner)
             VALUES (:name, :amount, :owner)"
        );

        $stmt->bindValue(':name', $item->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':amount', $item->getAmount(), PDO::PARAM_INT);
        $stmt->bindValue(':owner', $item->getOwner(), PDO::PARAM_INT);

        $stmt->execute();

        $item->setId($this->connection->lastInsertId());

        return $item;
    }

    public function update(Item $item): void {
        $stmt = $this->connection->prepare(
            "UPDATE items SET 
                name = :name,
                amount = :amount,
                owner = :owner
             WHERE id = :id"
        );

        $stmt->bindValue(':id', $item->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $item->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':amount', $item->getAmount(), PDO::PARAM_INT);
        $stmt->bindValue(':owner', $item->getOwner(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete(int $id): void {
        $stmt = $this->connection->prepare(
            "DELETE FROM items WHERE id = :id"
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
