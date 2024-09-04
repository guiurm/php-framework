<?php

namespace src\Models;

class User
{
   public function __construct(
      private string $_name
   ) {}

   public function getName(): string
   {
      return $this->_name;
   }
}
