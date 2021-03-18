<?php

namespace floor12\MindBox\Tests;

use floor12\MindBox\MindBoxClient;
use floor12\MindBox\MindBoxRequest;
use PHPUnit\Framework\TestCase;

class MindBoxRequestTest extends TestCase
{
    /** @var MindBoxRequest */
    private $testRequest;

    public function setUp(): void
    {
        $this->testRequest = new MindBoxRequest();
    }

    public function testSetMode()
    {
        $this->testRequest->setMode(MindBoxClient::MODE_ASYNCHRONOUS);
        $this->assertEquals(MindBoxClient::MODE_ASYNCHRONOUS, $this->testRequest->getMode());

        $this->testRequest->setMode(MindBoxClient::MODE_SYNCHRONOUS);
        $this->assertEquals(MindBoxClient::MODE_SYNCHRONOUS, $this->testRequest->getMode());
    }

    public function testGetBodyAsJson()
    {
        $this->testRequest->setMode(MindBoxClient::MODE_ASYNCHRONOUS);
        $this->testRequest->setBody(['test' => ['some' => 'data']]);
        $this->assertEquals(json_encode($this->testRequest->getBody()), $this->testRequest->getBodyAsJson());
    }

    public function testIsAsync()
    {
        $this->testRequest->setMode(MindBoxClient::MODE_ASYNCHRONOUS);
        $this->assertTrue($this->testRequest->isAsync());

        $this->testRequest->setMode(MindBoxClient::MODE_SYNCHRONOUS);
        $this->assertFalse($this->testRequest->isAsync());
    }

    public function testSetDeviceUUID()
    {
        $deviceUUID = md5(time());
        $this->testRequest->setDeviceUUID($deviceUUID);
        $this->assertEquals($deviceUUID, $this->testRequest->getDeviceUUID());
    }

    public function testSetBody()
    {
        $testBody = ['test' => ['some' => 'data']];
        $this->testRequest->setBody($testBody);
        $this->assertEquals($testBody, $this->testRequest->getBody());
    }

    public function testSetOperationName()
    {
        $operationName = 'testOperationName';
        $this->testRequest->setOperationName($operationName);
        $this->assertEquals($operationName, $this->testRequest->getOperationName());
    }
}
