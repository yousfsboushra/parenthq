<?php
namespace App\Library\Services\DataFormatters;
use App\Library\Services\Contracts\DataFormatter;

Class JsonFormatter implements DataFormatter{

    public function format($items){
        return json_encode($items);
    }
}