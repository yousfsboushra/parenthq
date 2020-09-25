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
            'DataProviderX' => new DataProviderX(),
            'DataProviderY' => new DataProviderY(),
        );
    }

    public function get(){
        return $this->providers;
    }

    public function generateData($length){
        foreach($this->providers as $provider){
            $provider->generateData($length);
        }
    }
}