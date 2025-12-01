<?php

namespace Model;

use JsonSerializable;

class Member implements JsonSerializable {
    //implementando essa interface, a função json_enconde() terá acesso
    //aos membros privados do objeto através do método jsonSerialize().
 
    private ?int $id;
    private string $name;
    private float $gold;
    private int $role;
    private int $team;

    //construtor
    public function __construct(
        string $name,
        float $gold, 
        int $role, 
        int $team, 
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = trim($name);
        $this->gold = $gold;
        $this->role = $role;
        $this->team = $team;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getGold(): int {
        return $this->gold;
    }

    public function getrole(): int {
        return $this->role;
    }

    public function getTeam(): int {
        return $this->team;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setName(string $name) {
        $this->name = trim($name);
    }

    public function setGold(int $gold) {
        $this->gold = $gold;
    }

    public function setrole(int $role) {
        $this->role = $role;
    }

    public function setTeam(int $role) {
        $this->role = $role;
    }

    //a interface JsonSerializable exige a implementação desse método
    //basicamene ele retorna todas (mas poderáimos customizar) os atributos do curso,
    //agora com acesso público, de forma que a função json_encode() possa acessá-los
    public function jsonSerialize(): array {
        $vars = get_object_vars($this);
        return $vars;
    }
}