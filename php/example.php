<?php
try {
    $params = [
      'method' => 'GET',
      'body' => [],
      'url' => 'https://finfini.com/api/v2/client/info',
      'F-INFINI-Timestamp' => '2016-01-26T10:42:01.000+07:00',
      'F-INFINI-Key' => 'WVhCcGEyVjVLMVJ5YjJ4cElFbEViMjFwUUd0aGJXRnlZbUY1YVM1amIyMHJNVFV3TURFNU5USTFOQ3M9'
    ];

    $signature = new Signature($params);
    return $signature->signature();

  } catch (\Exception $e) {

    echo $e->getMessage();
  }
?>