<?php

namespace indigerd\scenarios\validation\validator;

abstract class Validator implements ValidatorInterface
{
    protected $skipOnEmpty;

    protected $message;

    public function __construct(array $params = [])
    {
        foreach ($params as $name => $value) {
            $accessor = 'set' . ucfirst($name);
            if (method_exists($this, $accessor)) {
                $this->$accessor($value);
            }
        }
    }

    public function setSkipOnEmpty($value) : self
    {
        $this->skipOnEmpty = (bool)$value;
        return $this;
    }

    public function setMessage($message) : self
    {
        $this->message = (string)$message;
        return $this;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public abstract function validate($value, array $context = []) : bool;
}
