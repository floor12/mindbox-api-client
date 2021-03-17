<?php


namespace floor12\MindBox;


class MindBoxRequest
{
    protected string $operationName;
    protected array|null $body = null;
    protected $deviceUUID;
    protected $mode = MindBoxClient::MODE_SYNCHRONOUS;

    public function getOperationName(): string
    {
        return $this->operationName;
    }

    public function getDeviceUUID(): ?string
    {
        return $this->deviceUUID;
    }

    public function getBody(): ?array
    {
        return $this->body;
    }

    public function getBodyAsJson(): string
    {
        return json_encode($this->body);
    }

    public function getMode(): int
    {
        return $this->mode;
    }

    public function isAsync(): bool
    {
        return $this->mode === MindBoxClient::MODE_ASYNCHRONOUS;
    }

    public function setDeviceUUID(?string $deviceUUID): void
    {
        $this->deviceUUID = $deviceUUID;
    }

    public function setMode(int $mode): void
    {
        $this->mode = $mode;
    }

    public function setOperationName($operationName): void
    {
        $this->operationName = $operationName;
    }

    public function setBody(array $body): void
    {
        $this->body = $body;
    }


}
