<?php declare(strict_types=1);

namespace indigerd\scenarios\validation\validator;

class IntegerValidator extends NumberValidator
{
    protected $pattern = '/^\s*[+-]?\d+\s*$/';

    protected $message = 'Value must be an integer';
}
