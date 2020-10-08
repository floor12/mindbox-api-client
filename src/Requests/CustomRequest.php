<?php


namespace floor12\MindBox\Requests;


class CustomRequest extends MindBoxRequest
{
    /**
     * @param string|null $operationName
     * @param array|null $body
     * @param int|null $mode
     * @param string|null $deviceUUID
     */
    public function __construct(
        string $operationName = null,
        array $body = null,
        int $mode = null,
        string $deviceUUID = null)
    {
        $this->operationName = $operationName;
        $this->body = $body;
        $this->mode = $mode;
        $this->deviceUUID = $deviceUUID;
    }

    /**
     * @param mixed $operationName
     */
    public function setOperationName($operationName): void
    {
        $this->operationName = $operationName;
    }

    /**
     * @param array $body
     */
    public function setBody(array $body): void
    {
        $this->body = $body;
    }


}
