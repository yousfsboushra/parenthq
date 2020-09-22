<?php
namespace App\Library\Services\Readers;
  
use App\Library\Services\Contracts\DataReader;
  
class JsonApiReader implements DataReader
{
    public function read()
    {
      return 'Output from Json Api Reader';
    }
}