<?php

namespace indigerd\scenarios\validation\validator;

class RequiredValidator extends AbstractValidator
{
    protected $message = 'Value is required';

    public function validate($value, array $context = []): bool
    {
        if (empty($value)) {
            return false;
        }
        return true;
    }
}
