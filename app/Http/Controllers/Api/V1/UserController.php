<?php

namespace App\Http\Controllers\Api\V1;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Library\Services\Contracts\DataReader;

class UserController extends BaseController
{
    public function index(DataReader $reader){
        //$json = file_get_contents('https://bitbucket.org/!api/2.0/snippets/parenthq/Lrgexj/b6497026d572dadc1e9e14dc08a2e81e73f65040/files/DataProviderX.json');
        //return $json;


        
        return $reader->read();
    }
}
