<?php

namespace src\Models;

class User
{
    public function __construct(
        private readonly ?string $name,
        private readonly ?string $email,
        private readonly ?string $password,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }
}
