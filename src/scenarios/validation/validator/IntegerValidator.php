<?php

namespace indigerd\scenarios\validation\validator;

class IntegerValidator extends Validator
{
    protected $pattern = '/^\s*[+-]?\d+\s*$/';

    protected function normalizeNumber($value) : string
    {
        $value = (string)$value;
        $localeInfo = localeconv();
        $decimalSeparator = isset($localeInfo['decimal_point']) ? $localeInfo['decimal_point'] : null;

        if ($decimalSeparator !== null && $decimalSeparator !== '.') {
            $value = str_replace($decimalSeparator, '.', $value);
        }
        return $value;
    }

    public function validate($value, array $context = []): bool
    {
        if (!preg_match($this->pattern, $this->normalizeNumber($value))) {
            return false;
        }
        return true;
    }

    public function getMessage() : string
    {
        return 'Value must be an integer';
    }
}
