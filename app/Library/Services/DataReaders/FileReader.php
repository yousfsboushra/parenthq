<?php
namespace App\Library\Services\DataReaders;
  
use App\Library\Services\Contracts\DataReader;
  
class FileReader implements DataReader
{
    private $filepath;

    public function __construct($filepath){
        $this->filepath = (isset($filepath))? $filepath : "";
    }

    public function read(){
        $content = "";
        if (file_exists($this->filepath)) {
            $content = "";
            $fh = fopen($this->filepath,'r');
            while ($line = fgets($fh)) {
                $content .= $line;
            }
            fclose($fh);
        }
        return $content;
    }
}