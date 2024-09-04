<?php

namespace src\Models;

class User
{
   private string $_name = '';
   public function __construct() {}

   public function getName(): string
   {
      return $this->_name;
   }
}
