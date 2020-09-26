<?php

namespace App\Http\Controllers\Api\V1;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Library\Services\DataProviderAggregator;
use App\Library\Services\DataFormatters\JsonFormatter;

class UserController extends BaseController
{
    private $providersAggregator;
    private $formatter;

    public function __construct(DataProviderAggregator $providersAggregator, JsonFormatter $formatter){
        $this->providersAggregator = $providersAggregator;
        $this->formatter = $formatter;
    }

    public function index(Request $request){
        $providers = $this->providersAggregator->get();
        $filters = $this->getFilters($request);

        echo "[";
        $c = 0;
        foreach($providers as $provider){
            foreach($provider->getData() as $user){
                if($this->isUserPassFilters($user, $filters)){
                    if($c > 0){
                        echo ",";
                    }
                    echo json_encode($user);
                    flush();
                    $c++;
                }
            }
        }
        echo "]";
    }

    public function generate(Request $request){
        $length = $request->input('length');
        if(!is_numeric($length)){
            $length = 10;
        }
        $this->providersAggregator->generateData($length);
    }

    private function isUserPassFilters($user, $filters){
        if(!empty($filters)){
            foreach($filters as $filter => $value){
                switch($filter){
                    case 'balanceMin':
                        if($user['balance'] < $value){
                            return false;
                        }
                    break;
                    case 'balanceMax':
                        if($user['balance'] > $value){
                            return false;
                        }
                    break;
                    default:
                        if($user[$filter] != $value){
                            return false;
                        }
                }
            }
        }
        return true;
    }

    private function getFilters($request){
        $filters = array();
        
        $provider = $request->input('provider');
        if($provider){
            $filters['provider'] = $provider;
        }
        $statusCode = $request->input('statusCode');
        if($statusCode){
            $filters['status'] = $statusCode;
        }
        $balanceMin = $request->input('balanceMin');
        if(is_numeric($balanceMin)){
            $filters['balanceMin'] = $balanceMin;
        }
        $balanceMax = $request->input('balanceMax');
        if(is_numeric($balanceMax)){
            $filters['balanceMax'] = $balanceMax;
        }
        $currency = $request->input('currency');
        if($currency){
            $filters['currency'] = $currency;
        }

        return $filters;
    }
}
