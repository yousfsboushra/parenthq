<?php

namespace App\Library\Services\Contracts;
  
Interface DataProvider
{
    public function getName();
    public function getData();
}