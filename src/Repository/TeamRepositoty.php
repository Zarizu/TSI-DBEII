<?php

namespace Model;

use JsonSerializable;

class Team implements JsonSerializable {
    //implementando essa interface, a função json_enconde() terá acesso
    //aos membros privados do objeto através do método jsonSerialize().
 
    private ?int $id;
    private string $name;
    private float $gold;

    //construtor
    public function __construct(
        string $name,
        float $gold,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = trim($name);
        $this->gold = $gold;
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

    public function setId(int $id) { 
        //repare que id só admite nulo no processo de criação, aqui não!
        $this->id = $id;
    }

    public function setName(string $name) {
        $this->name = trim($name);
    }

    public function setGold(int $gold) {
        $this->gold = $gold;
    }

    //a interface JsonSerializable exige a implementação desse método
    //basicamene ele retorna todas (mas poderáimos customizar) os atributos do curso,
    //agora com acesso público, de forma que a função json_encode() possa acessá-los
    public function jsonSerialize(): array {
        $vars = get_object_vars($this);
        return $vars;
    }
}