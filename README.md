# mindbox-api-client

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/floor12/mindbox-api-client/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/floor12/mindbox-api-client/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/floor12/mindbox-api-client/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/floor12/mindbox-api-client/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/floor12/mindbox-api-client/badges/build.png?b=main)](https://scrutinizer-ci.com/g/floor12/mindbox-api-client/build-status/main)

General abstraction over the Mindbox API.

To send requests to the Mindbox API you should extend the `MindBoxRequest` class, set `MindBoxRequest::operationName`
and `MindBoxRequest::body` with your data.

```php
use floor12\MindBox\MindBoxClient;
use floor12\MindBox\MindBoxRequest;

class SomeMindboxRequest extends MindBoxRequest
{
    /** @var string */
    protected $operationName = 'Website.CheckCustomer';
    protected $mode = MindBoxClient::MODE_SYNCHRONOUS;

    /**
     * @param $userId int
     */
    public function __construct(int $userId)
    {
        $this->body = [
            'customer' => [
                'ids' =>
                    ['externalId' => $userId]
            ]
        ];
    }
}



$apiKey = '4a942bc1';
$apiEndPoint = 'Website.ExampleEndPoint';

$client = new MindBoxClient($apiKey, $apiEndPoint);
$request = new SomeMindboxRequest(10);
$client->sendData($request);
$response = $client->getResponse();
```