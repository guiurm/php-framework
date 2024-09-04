<?php

namespace src\Models;

class User
{
   private string $_name = '';
   private string $_email = '';

   public function __construct() {}

   public function getName(): string
   {
      return $this->_name;
   }

   public function setName(string $name): void
   {
      $this->_name = $name;
   }

   public function getEmail(): string
   {
      return $this->_email;
   }

   public function setEmail(string $email): void
   {
      $this->_email = $email;
   }
}
