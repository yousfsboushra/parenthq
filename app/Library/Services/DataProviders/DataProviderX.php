<?php
namespace App\Library\Services\DataProviders;

use App\Library\Services\Contracts\DataProvider;
use App\Library\Services\DataReaders\FileReader;
use App\Library\Services\DataParsers\JsonParser;
  
class DataProviderX implements DataProvider
{
  private $reader;
  private $parser;
  private $status;

  public function __construct(){
    $this->reader = new FileReader('DataProviderX.json');
    $this->parser = new JsonParser();
    $this->status = array(
      1 => 'authorised',
      2 => 'decline',
      3 => 'refunded',
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
    return array(
      'id' => $user->parentIdentification,
      'email' => $user->parentEmail,
      'currency' => $user->Currency,
      'amount' => $user->parentAmount,
      'created_at' => $user->registerationDate,
      'status' => $this->status[$user->statusCode],
    );
  }
}