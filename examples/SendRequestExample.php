<?php

use floor12\MindBox\MindBoxClient;
use GuzzleHttp\Exception\GuzzleException;

$apiKey = '4a942bc1';
$apiEndPoint = 'Website.ExampleEndPoint';

$client = new MindBoxClient($apiKey, $apiEndPoint);
$request = new CheckCustomerExampleRequest();
$request->setUserIdToCheck(1);

try {
    $client->sendData($request);
    $response = $client->getResponse();
} catch (GuzzleException $e) {
    echo $e->getMessage();
}
