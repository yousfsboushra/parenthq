<?php

namespace App\Library\Services\DataParsers;
use App\Library\Services\Contracts\DataParser;

Class JsonParser implements DataParser{
    
    public function parse($json){
        return json_decode($json);
    }
}