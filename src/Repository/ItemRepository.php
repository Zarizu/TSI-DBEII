<?php

namespace Repository;

use Database\Database;
use Model\Item;
use PDO;

class ItemRepository {
<<<<<<< Updated upstream
    private $connection;
=======
    private PDO $connection;
>>>>>>> Stashed changes

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function findAll(): array {
        $stmt = $this->connection->prepare("SELECT * FROM items");
        $stmt->execute();

        $items = [];
<<<<<<< Updated upstream
        while ($row = $stmt->fetch()) {
            $item = new Item(
                id: $row['id'],
                name: $row['name'],
                amount: $row['amount'],
                owner: $row['owner'],
            );
            $items[] = $item;
=======
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item(
                id: $row['id'],
                name: $row['name'],
                amount: $row['amount'],
                owner: $row['owner']
            );
>>>>>>> Stashed changes
        }

        return $items;
    }

    public function findByName(string $name): array {
<<<<<<< Updated upstream
        $stmt = $this->connection->prepare("SELECT * FROM items WHERE name like :name");
=======
        $stmt = $this->connection->prepare(
            "SELECT * FROM items WHERE name LIKE :name"
        );
>>>>>>> Stashed changes
        $stmt->bindValue(':name', '%' . $name . '%');
        $stmt->execute();

        $items = [];
<<<<<<< Updated upstream
        while ($row = $stmt->fetch()) {
            $item = new Item(
                id: $row['id'],
                name: $row['name'],
                amount: $row['amount'],
                owner: $row['owner'],
            );
            $items[] = $item;
=======
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item(
                id: $row['id'],
                name: $row['name'],
                amount: $row['amount'],
                owner: $row['owner']
            );
>>>>>>> Stashed changes
        }

        return $items;
    }

<<<<<<< Updated upstream
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

=======
>>>>>>> Stashed changes
    public function findById(int $id): ?Item {
        $stmt = $this->connection->prepare("SELECT * FROM items WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

<<<<<<< Updated upstream
        $item = new Item(
            id: $row['id'],
            name: $row['name'],
            amount: $row['amount'],
            owner: $row['owner'],
        );

        return $item;
    }

    public function create(Item $item): Item {
        $stmt = $this->connection->prepare("INSERT INTO items (name, amount, owner) VALUES (:name, :amount, :owner)");
        $stmt->bindValue(':name', $item->getName());
        $stmt->bindValue(':amount', $item->getAmount(), PDO::PARAM_INT);
        $stmt->bindValue(':owner', $item->getOwner(), PDO::PARAM_INT);
=======
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

>>>>>>> Stashed changes
        $stmt->execute();

        $item->setId($this->connection->lastInsertId());

        return $item;
    }

    public function update(Item $item): void {
<<<<<<< Updated upstream
        $stmt = $this->connection->prepare("UPDATE items SET name = :name, amount = :amount, owner = :owner WHERE id = :id;");
=======
        $stmt = $this->connection->prepare(
            "UPDATE items SET 
                name = :name,
                amount = :amount,
                owner = :owner
             WHERE id = :id"
        );

>>>>>>> Stashed changes
        $stmt->bindValue(':id', $item->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $item->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':amount', $item->getAmount(), PDO::PARAM_INT);
        $stmt->bindValue(':owner', $item->getOwner(), PDO::PARAM_INT);
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
        $stmt->execute();
    }

    public function delete(int $id): void {
<<<<<<< Updated upstream
        $stmt = $this->connection->prepare("DELETE FROM item WHERE id = :id;");
=======
        $stmt = $this->connection->prepare(
            "DELETE FROM items WHERE id = :id"
        );
>>>>>>> Stashed changes
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
