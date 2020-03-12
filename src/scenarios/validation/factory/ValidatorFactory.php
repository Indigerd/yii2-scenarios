<?php declare(strict_types=1);

namespace indigerd\scenarios\validation\factory;

use indigerd\scenarios\validation\validator\ArrayEachValidator;
use indigerd\scenarios\validation\validator\ArrayValidator;
use indigerd\scenarios\validation\validator\EmailValidator;
use indigerd\scenarios\validation\validator\IntegerValidator;
use indigerd\scenarios\validation\validator\InValidator;
use indigerd\scenarios\validation\validator\NumberValidator;
use indigerd\scenarios\validation\validator\RequiredValidator;
use indigerd\scenarios\validation\validator\StringValidator;
use indigerd\scenarios\validation\validator\ValidatorInterface;

class ValidatorFactory
{
    protected $validators = [
        'integer' => IntegerValidator::class,
        'required' => RequiredValidator::class,
        'array' => ArrayValidator::class,
        'arrayEach' => ArrayEachValidator::class,
        'email' => EmailValidator::class,
        'in' => InValidator::class,
        'number' => NumberValidator::class,
        'string' => StringValidator::class
    ];

    public function create(string $validatorName, array $params = []) : ValidatorInterface
    {
        if (!isset($this->validators[$validatorName])) {
            throw new \InvalidArgumentException("Validator $validatorName not supported");
        }
        return new $this->validators[$validatorName]($params);
    }
}
