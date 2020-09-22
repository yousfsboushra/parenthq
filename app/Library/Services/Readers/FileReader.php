<?php
namespace App\Library\Services\Readers;
  
use App\Library\Services\Contracts\DataReader;
  
class FileReader implements DataReader
{
    public function read()
    {
      return 'Output from File Reader';
    }
}