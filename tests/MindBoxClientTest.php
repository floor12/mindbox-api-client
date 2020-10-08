<?php

namespace floor12\MindBox\Tests;

use floor12\MindBox\Exceptions\EmptyApiEndPointException;
use floor12\MindBox\Exceptions\EmptyApiKeyException;
use floor12\MindBox\MindBoxClient;
use floor12\MindBox\MindBoxRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class MindBoxClientTest extends TestCase
{

    public function testNoApiKey()
    {
        $this->expectException(EmptyApiKeyException::class);
        new MindBoxClient('', 'test');
    }

    public function testNoEndpointKey()
    {
        $this->expectException(EmptyApiEndPointException::class);
        new MindBoxClient('key', '');
    }

    public function testRequestSendsSuccess()
    {
        // Prepare test data
        $mindBoxSecretKey = 'test-secret-key';
        $mindBoxEndpoint = 'test.endpoint';
        $operationName = 'test.operation';
        $deviceUUID = 'test-device-uuid';
        $body = ['test' => 'body'];

        $expectedUri = MindBoxClient::ASYNC_MINDBOX_API_URL . '?' .
            http_build_query([
                'endpointId' => $mindBoxEndpoint,
                'operation' => $operationName,
                'deviceUUID' => $deviceUUID,
            ]);

        // Setting up Guzzle Client Mock
        $container = [];
        $history = Middleware::history($container);
        $mock = new MockHandler([new Response(200, ['Content-Length' => 0]),]);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);
        $httpClient = new Client([
            'handler' => $handlerStack,
            'base_uri' => MindBoxClient::ASYNC_MINDBOX_API_URL
        ]);

        // Create  and send MindBox request
        $request = new MindBoxRequest();
        $request->setOperationName($operationName);
        $request->setBody($body);
        $request->setMode(MindBoxClient::MODE_ASYNCHRONOUS);
        $request->setDeviceUUID($deviceUUID);

        $mindBoxClient = new MindBoxClient(
            $mindBoxSecretKey,
            $mindBoxEndpoint,
            $httpClient
        );

        $mindBoxClient->sendData($request);

        // Checking results
        /** @var Request $request */
        $request = $container[0]['request'];
        $bodyContent = (string)$request->getBody()->getContents();

        $this->assertEquals($expectedUri, (string)$request->getUri());
        $this->assertEquals($body, json_decode($bodyContent, true));
        $this->assertEquals('application/json; charset=utf-8', $request->getHeader('Content-type')[0]);
    }


}
