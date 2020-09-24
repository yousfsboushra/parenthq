<?php
// This file is a clone from DataProviderX.php because both sources are similar
// The whole file may change according to the source
namespace App\Library\Services\DataProviders;

use App\Library\Services\Contracts\DataProvider;
use App\Library\Services\DataReaders\FileReader;
use App\Library\Services\DataParsers\JsonParser;
  
class DataProviderY implements DataProvider
{
  private $reader;
  private $parser;
  private $status;

  public function __construct(){
    $this->reader = new FileReader('DataProviderY.json');
    $this->parser = new JsonParser();
    $this->status = array(
      100 => 'authorised',
      200 => 'decline',
      300 => 'refunded',
    );
  }

  public function getData(){
    $json = $this->reader->read();
    $data = $this->parser->parse($json);
    
    $users = array();
    if(!empty($data->users)){
      foreach($data->users as $user){
        $users[] = $this->formatUser($user);
      }
    }
    return $users;
  }

  private function formatUser($user){
    $date = \DateTime::createFromFormat("d/m/Y", $user->created_at);
    return array(
      'id' => $user->id,
      'email' => $user->email,
      'currency' => $user->currency,
      'amount' => $user->balance,
      'created_at' => $date->format("Y-m-d"),
      'status' => $this->status[$user->status],
    );
  }
}