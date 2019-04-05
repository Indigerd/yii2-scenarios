<?php

namespace indigerd\scenarios\validation\validator;

class RequiredValidator extends Validator
{
    public function validate($value, array $context = []): bool
    {
        if (empty($value)) {
            return false;
        }
        return true;
    }

    public function getMessage() : string
    {
        return 'Value is required';
    }
}
