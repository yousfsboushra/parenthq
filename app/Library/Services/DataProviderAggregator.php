<?php
namespace App\Library\Services;
use App\Library\Services\Contracts\DataProvider;
use App\Library\Services\DataProviders\DataProviderX;
use App\Library\Services\DataProviders\DataProviderY;
  
class DataProviderAggregator
{
    private $providers;

    public function __construct(){
        $this->providers = array(
            new DataProviderX(),
            new DataProviderY(),
        );
    }

    public function get(){
        return $this->providers;
    }
}