<?php

namespace Model;

use JsonSerializable;

class Mission implements JsonSerializable {
    //implementando essa interface, a função json_enconde() terá acesso
    //aos membros privados do objeto através do método jsonSerialize().
 
    private ?int $id;
    private string $name;
    private string $description;
    private float $reward;

    //construtor
    public function __construct(
        string $name,
        float $reward, 
        int $description,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = trim($name);
        $this->reward = $reward;
        $this->description = $description;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getReward(): int {
        return $this->reward;
    }

    public function getDescription(): int {
        return $this->description;
    }

    public function getTeam(): int {
        return $this->team;
    }

    public function setId(int $id) { 
        //repare que id só admite nulo no processo de criação, aqui não!
        $this->id = $id;
    }

    public function setName(string $name) {
        $this->name = trim($name);
    }

    public function setReward(int $reward) {
        $this->reward = $reward;
    }

    public function setDescription(int $description) {
        $this->description = $description;
    }

    //a interface JsonSerializable exige a implementação desse método
    //basicamene ele retorna todas (mas poderáimos customizar) os atributos do curso,
    //agora com acesso público, de forma que a função json_encode() possa acessá-los
    public function jsonSerialize(): array {
        $vars = get_object_vars($this);
        return $vars;
    }
}