<?php
namespace App\Library\Services\DataReaders;
  
use App\Library\Services\Contracts\DataReader;
  
class ApiReader implements DataReader
{
    private $endpoint;
    private $headers;

    public function __construct($endpoint, $headers = array()){
        $this->endpoint = $endpoint;
        $this->headers = $headers;
    }

    public function read(){
        $content = array();
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $this->headers
        );
        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        if($info['http_code'] == 200){
            $content = json_decode($result);
        }
        curl_close($ch);
        return $content->users;
    }
}