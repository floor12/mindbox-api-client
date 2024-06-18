<?php


namespace floor12\MindBox;


use floor12\MindBox\Exceptions\EmptyApiEndPointException;
use floor12\MindBox\Exceptions\EmptyApiKeyException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use function GuzzleHttp\Psr7\build_query;

class MindBoxClient
{
    const MODE_ASYNCHRONOUS = 0;
    const MODE_SYNCHRONOUS = 1;
    const ASYNC_MINDBOX_API_URL = 'https://api.mindbox.ru/v3/operations/async';
    const SYNC_MINDBOX_API_URL = 'https://api.mindbox.ru/v3/operations/sync';
    const DEFAULT_HTTP_TIMEOUT = 2;

    /** @var string */
    private $endpointId;
    /** @var ClientInterface */
    private $client;
    /** @var string[] */
    private $headers;
    /** @var string */
    private $secretKey;
    /** @var ResponseInterface */
    private $response;
    /** @var Request */
    private $httpRequest;
    /** @var int */
    private $httpTimeOut = self::DEFAULT_HTTP_TIMEOUT;

    /**
     * @param string $secretKey
     * @param string $endpointId
     * @param ClientInterface|null $client
     * @throws EmptyApiEndPointException
     * @throws EmptyApiKeyException
     */
    public function __construct(
        string          $secretKey,
        string          $endpointId,
        ClientInterface $client = null)
    {
        $this->client = $client ?? new Client();

        $this->secretKey = $secretKey;
        $this->endpointId = $endpointId;

        if (empty($this->secretKey))
            throw new EmptyApiKeyException();

        if (empty($this->endpointId))
            throw new EmptyApiEndPointException();

        $this->headers = [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Authorization' => "Mindbox secretKey=\"{$this->secretKey}\""
        ];
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @param MindBoxRequest $mindBoxRequest
     * @throws GuzzleException
     */
    public function sendData(MindBoxRequest $mindBoxRequest): void
    {
        $httpRequestParams = [
            'endpointId' => $this->endpointId,
            'operation' => $mindBoxRequest->getOperationName(),
            'transactionId' => (new Uuid())->toString()
        ];


        if ($mindBoxRequest->getDeviceUUID()) {
            $httpRequestParams['deviceUUID'] = $mindBoxRequest->getDeviceUUID();
        }

        $baseUrl = $mindBoxRequest->isAsync() ? self::ASYNC_MINDBOX_API_URL : self::SYNC_MINDBOX_API_URL;

        $this->httpRequest = new Request(
            'POST',
            $baseUrl . '?' . build_query($httpRequestParams),
            $this->headers,
            $mindBoxRequest->getBodyAsJson()
        );
        $this->response = $this->client->send($this->httpRequest);
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return Request
     */
    public function getHttpRequest(): Request
    {
        return $this->httpRequest;
    }

    /**
     * @param int $httpTimeOut
     */
    public function setHttpTimeOut(int $httpTimeOut): void
    {
        $this->httpTimeOut = $httpTimeOut;
    }

}
