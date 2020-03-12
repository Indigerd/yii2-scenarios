<?php declare(strict_types=1);

namespace indigerd\scenarios\validation\validator;

class EmailValidator extends AbstractValidator
{
    protected $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';

    public function validate($value, array $context = []): bool
    {
        if ($this->skipOnEmpty and ($value === null || \trim($value) === '')) {
            return true;
        }
        if (!\is_string($value)) {
            return false;
        }
        return (bool)\preg_match($this->pattern, $value);
    }
}
