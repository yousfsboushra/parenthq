<?php
namespace App\Library\Services\DataReaders;
  
use App\Library\Services\Contracts\DataReader;
use JsonMachine\JsonMachine;
  
class JsonMachineFileReader implements DataReader
{
    private $filepath;

    public function __construct($filepath){
        $this->filepath = (isset($filepath))? $filepath : "";
    }

    public function read(){
        $data = array();
        if (file_exists($this->filepath)) {
            $jsonStream = JsonMachine::fromFile($this->filepath, "/users");
            foreach ($jsonStream as $name => $item) {
                $data[] = $item;
            }
        }
        return $data;
    }
}