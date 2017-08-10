<?php

namespace App\Library\Signature;

use Illuminate\Http\Request;

class Signature {

  private static $params, $json_body;

  public function __construct(array $request)
  {
    self::$params = $request;
  }

  private static function token(){
    $token = isset(self::$params['F-INFINI-Access-token']) ? self::$params['F-INFINI-Access-token'] : 0;
    return $token;
  }

  private static function method(){
    if(isset(self::$params['method'])){
        $method =  self::$params['method'];
        return $method;
    }else{
      throw new \Exception('Failed to prepare the signature of the request. Parameter method required');
    }
  }

  private static function url(){
    if(isset(self::$params['url'])){
        $url =  self::$params['url'];
        return $url;
    }else{
      throw new \Exception('Failed to prepare the signature of the request. Parameter url required');
    }
  }

  private static function api_key(){
    if(isset(self::$params['F-INFINI-Key'])){
        $key =  self::$params['F-INFINI-Key'];
        return $key;
    }else{
      throw new \Exception('Failed to prepare the signature of the request. Parameter API Key required');
    }
  }

  private static function body(){

    if(self::$params['body'] == []){
      $tes = parse_str(parse_url(self::$params['url'], PHP_URL_QUERY),$output);
      self::$json_body = (json_encode($output));
    }else{
      self::$json_body = (json_encode(self::$params['body']));
    }

    $body = strtolower(hash('sha256', self::$json_body));
    return $body;
  }

  private static function timestamp(){
    if(isset(self::$params['F-INFINI-Timestamp'])){
        $timestamp =  self::$params['F-INFINI-Timestamp'];
        return $timestamp;
    }else{
      throw new \Exception('Failed to prepare the signature of the request. Parameter Timestamp Key required');
    }
  }

  public function signature(){

    $hash = hash_hmac('sha256', ''.self::method().'|'.self::url().'|'.self::body().'|'.self::token().'|'.self::timestamp().'', self::api_key());

    return $hash;
  }

}