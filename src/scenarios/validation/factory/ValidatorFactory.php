<?php

namespace indigerd\scenarios\validation\factory;

use indigerd\scenarios\validation\validator\IntegerValidator;
use indigerd\scenarios\validation\validator\RequiredValidator;
use indigerd\scenarios\validation\validator\ValidatorInterface;

class ValidatorFactory
{
    protected $validators = [
        'integer' => IntegerValidator::class,
        'required' => RequiredValidator::class
    ];

    public function create(string $validatorName, array $params = []) : ValidatorInterface
    {
        if (!isset($this->validators[$validatorName])) {
            throw new \InvalidArgumentException("Validator $validatorName not supported");
        }
        return new $this->validators[$validatorName]($params);
    }
}
