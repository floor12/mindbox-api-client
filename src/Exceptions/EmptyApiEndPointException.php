<?php


namespace floor12\MindBox\Exceptions;


class EmptyApiEndPointException extends MindBoxException
{
    protected $message = 'The MindBox api endpoint name cannot be empty.';
}
