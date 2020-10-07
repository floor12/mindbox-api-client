<?php


namespace floor12\MindBox\Exceptions;


class EmptyApiKeyException extends MindBoxException
{
    protected $message = 'The MindBox API key cannot be empty.';
}
