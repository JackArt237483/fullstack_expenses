<?php

namespace App\DTO;

// Контейннер для передачи даныых USER в связи с дургие методами
class UserDTO {
    public int $id;
    public string $name;
    public string $email;
    public string $passwordHash;
    public function __construct(int $id, string $name, string $email, string $passwordHash){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }
    // Пишем static чтобы е вызывать NEW обьект
    // и self для того чтобы ссылаться на текущий класс UserDTO
    public static function fromArray(array $data): self{
        // создаем класс UserDTO чтобы не харкодить
        return new self(
            (int)$data['id'] ?? null,
                (string)$data['name'] ?? "",
                (string)$data['email'] ?? "",
                (string)$data['passwordHash'] ?? ""

        );
    }
}