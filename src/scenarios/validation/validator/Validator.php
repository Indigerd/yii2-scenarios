<?php

namespace indigerd\scenarios\validation\validator;

abstract class Validator implements ValidatorInterface
{
    protected $skipOnEmpty;

    public function __construct(array $params = [])
    {
        foreach ($params as $name => $value) {
            $accessor = 'set' . ucfirst($name);
            if (method_exists($this, $accessor)) {
                $this->$accessor($value);
            }
        }
    }

    public function setSkipOnEmpty($value)
    {
        $this->skipOnEmpty = (bool)$value;
    }

    public abstract function validate($value, array $context = []) : bool;

    public abstract function getMessage() : string;
}
