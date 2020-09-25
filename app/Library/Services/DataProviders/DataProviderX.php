<?php
namespace App\Library\Services\DataProviders;

use App\Library\Services\Contracts\DataProvider;
use App\Library\Services\DataReaders\FileReader;
use App\Library\Services\DataReaders\JsonMachineFileReader;
use App\Library\Services\DataParsers\JsonParser;
  
class DataProviderX implements DataProvider
{
  private $name = "DataProviderX";
  private $reader;
  private $parser;
  private $status;

  public function __construct(){
    $this->reader = new JsonMachineFileReader('generatedDataX100.json');
    $this->parser = new JsonParser();
    $this->status = array(
      1 => 'authorised',
      2 => 'decline',
      3 => 'refunded',
    );
  }

  public function getName(){
    return $this->name;
  }

  public function getData(){
    $data = $this->reader->read();
    // $data = $this->parser->parse($this->reader->read());
    
    $users = array();
    if(!empty($data)){
      foreach($data as $user){
        $users[] = $this->formatUser($user);
      }
    }
    return $users;
  }

  private function formatUser($user){
    return array(
      'id' => $user->parentIdentification,
      'email' => $user->parentEmail,
      'currency' => $user->Currency,
      'balance' => $user->parentAmount,
      'created_at' => $user->registerationDate,
      'status' => $this->status[$user->statusCode],
      'provider' => 'DataProviderX'
    );
  }

  public function generateData($length){
    $fp = fopen('generatedDataX.json', 'a');
    fwrite($fp, '{"users":['); 
    for($i=0;$i<$length;$i++){
      if($i>0){
        fwrite($fp, ',');
      }
      fwrite($fp, json_encode($this->generateUser()));
    }
    fwrite($fp, ']}');
    fclose($fp);
  }

  private function generateUser(){
    $currencies = array('EGP', 'EUR', 'USD', 'AED');
    return array(
      'parentIdentification' => uniqid(),
      'parentEmail' => $this->generateRandomString(20) . '@gmail.com',
      'Currency' => $currencies[rand(0, 3)],
      'parentAmount' => rand(1, 10000),
      'registerationDate' => rand(2000, 2020) . "-" . rand(1, 12) . "-" . rand(1, 28),
      'statusCode' => rand(1, 3),
    );
  }

  private function generateRandomString($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyz_.';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }
}