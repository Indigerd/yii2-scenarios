<?php

namespace indigerd\scenarios\exception;

use Throwable;
use yii\base\Model;

class ModelValidateException extends \Exception
{
    protected $model;

    public function __construct(Model $model, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->model = $model;
        parent::__construct($message, $code, $previous);
    }

    public function getModel() : Model
    {
        return $this->model;
    }
}
