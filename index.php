<?php

$ch = curl_init();

$headers = [
  "Authorization: token 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"
  //"User-Agent: visigoth21"
];

$payload = json_encode([
  "name" => "Created from API",
  "description" => "an example API-created repo"
]);


  //CURLOPT_COOKIESESSION => true,
  //CURLOPT_COOKIEJAR => "cookie.txt",

curl_setopt_array($ch, [
  CURLOPT_URL => "https://github.com/visigoth21/task_test",  
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => $headers,
  CURLOPT_USERAGENT => "visigoth21",
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>$payload
]);

$response = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch); 

echo $status_code, "\n";

//print_r($response_headers);
echo $response, "\n";
