<?php

namespace indigerd\scenarios\exception;

use Throwable;
use yii\web\Request;

class RequestValidateException extends \Exception
{
    protected $request;

    protected $errorCollection = [];

    public function __construct(
        Request $request,
        array $errorCollection = [],
        string $message = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        $this->request = $request;
        $this->errorCollection = $errorCollection;
        parent::__construct($message, $code, $previous);
    }

    public function getRequest() : Request
    {
        return $this->request;
    }

    public function getErrorCollection() : array
    {
        return $this->errorCollection;
    }
}
