<?php


namespace floor12\MindBox\Requests;


use floor12\MindBox\MindBoxClient;

abstract class MindBoxRequest
{
    /** @var string */
    protected $operationName;
    /** @var array */
    protected $body = [];
    /** @var string|null */
    protected $deviceUUID;
    /** @var int */
    protected $mode = MindBoxClient::MODE_SYNCHRONOUS;

    /**
     * @return string
     */
    public function getOperationName()
    {
        return $this->operationName;
    }

    /**
     * @return string|null
     */
    public function getDeviceUUID(): ?string
    {
        return $this->deviceUUID;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getBodyAsJson(): string
    {
        return json_encode($this->body);
    }

    /**
     * @return int
     */
    public function getMode(): int
    {
        return $this->mode;
    }

    /**
     * @return bool
     */
    public function isAsync(): bool
    {
        return $this->mode === MindBoxClient::MODE_ASYNCHRONOUS;
    }
}
