<?php

namespace App\Http\Controllers\Api\V1;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Library\Services\DataProviderAggregator;
use App\Library\Services\DataFormatters\JsonFormatter;

class UserController extends BaseController
{
    public function index(DataProviderAggregator $providersAggregator, JsonFormatter $formatter){
        $users = array();
        $providers = $providersAggregator->get();
        foreach($providers as $provider){
            $tmpUsers = $provider->getData();
            foreach($tmpUsers as $user){
                $users[] = $user;
            }
        }

        return $formatter->format($users);
    }
}
