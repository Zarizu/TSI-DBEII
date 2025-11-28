<?php

namespace Model;

use JsonSerializable;

class Role implements JsonSerializable {
    //implementando essa interface, a função json_enconde() terá acesso
    //aos membros privados do objeto através do método jsonSerialize().
 
    private ?int $id;
    private string $name;

    //construtor
    public function __construct(
        string $name,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = trim($name);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setId(int $id) { 
        //repare que id só admite nulo no processo de criação, aqui não!
        $this->id = $id;
    }

    public function setName(string $name) {
        $this->name = trim($name);
    }

    //a interface JsonSerializable exige a implementação desse método
    //basicamene ele retorna todas (mas poderáimos customizar) os atributos do curso,
    //agora com acesso público, de forma que a função json_encode() possa acessá-los
    public function jsonSerialize(): array {
        $vars = get_object_vars($this);
        return $vars;
    }
}