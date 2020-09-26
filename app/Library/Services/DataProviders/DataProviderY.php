<?php
// This file is a clone from DataProviderX.php because both sources are similar
// The whole file may change according to the source
namespace App\Library\Services\DataProviders;

use App\Library\Services\Contracts\DataProvider;
use App\Library\Services\DataReaders\FileReader;
use App\Library\Services\DataReaders\JsonMachineFileReader;
  
class DataProviderY implements DataProvider
{

  private $name = "DataProviderY";
  private $reader;
  private $status;

  public function __construct(){
    $this->reader = new JsonMachineFileReader('DataProviderY.json');
    $this->status = array(
      100 => 'authorised',
      200 => 'decline',
      300 => 'refunded',
    );
  }

  public function getName(){
    return $this->name;
  }

  public function getData(){
    $users = array();
    foreach($this->reader->read() as $user){
      $users[] = $this->formatUser($user);
    }
    return $users;
  }

  private function formatUser($user){
    if(is_array($user)){
      $date = \DateTime::createFromFormat("d/m/Y", $user['created_at']);
      return array(
        'id' => $user['id'],
        'email' => $user['email'],
        'currency' => $user['currency'],
        'balance' => $user['balance'],
        'created_at' => $date->format("Y-m-d"),
        'status' => $this->status[$user['status']],
        'provider' => 'DataProviderY'
      );
    }
    $date = \DateTime::createFromFormat("d/m/Y", $user->created_at);
    return array(
      'id' => $user->id,
      'email' => $user->email,
      'currency' => $user->currency,
      'balance' => $user->balance,
      'created_at' => $date->format("Y-m-d"),
      'status' => $this->status[$user->status],
      'provider' => 'DataProviderY'
    );
  }


  //For Testing
  public function generateData($length){
    $object = array(
      'users' => array()
    );
    for($i=0;$i<$length;$i++){
      $object['users'][] = $this->generateUser();
    }
    file_put_contents('generatedDataY.json', json_encode($object));
  }

  private function generateUser(){
    $currencies = array('EGP', 'EUR', 'USD', 'AED');
    return array(
      'id' => uniqid(),
      'email' => $this->generateRandomString(20) . '@yahoo.com',
      'currency' => $currencies[rand(0, 3)],
      'balance' => rand(1, 5000),
      'created_at' => rand(1, 28) . "/" . rand(1, 12) . "/" . rand(2000, 2020),
      'status' => rand(1, 3) * 100,
    );
  }

  private function generateRandomString($length = 10) {
      $characters = 'abcdefghijklmnopqrstuvwxyz_.';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }
}