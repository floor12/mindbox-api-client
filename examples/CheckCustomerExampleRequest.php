<?php


use floor12\MindBox\MindBoxClient;
use floor12\MindBox\Requests\MindBoxRequest;

class CheckCustomerExampleRequest extends MindBoxRequest
{
    /** @var string */
    protected $operationName = 'Website.CheckCustomer';
    protected $mode = MindBoxClient::MODE_SYNCHRONOUS;

    /**
     * @param $userId int
     */
    public function setUserIdToCheck(int $userId): void
    {
        $this->body = [
            'customer' => [
                'ids' =>
                    ['externalId' => $userId]
            ]
        ];
    }
}
