<?php declare(strict_types=1);

namespace indigerd\scenarios\validation\validator;

abstract class AbstractValidator implements ValidatorInterface
{
    protected $skipOnEmpty = true;

    protected $message = 'Validation failed';

    public function __construct(array $params = [])
    {
        foreach ($params as $name => $value) {
            $accessor = 'set' . \ucfirst($name);
            if (\method_exists($this, $accessor)) {
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
