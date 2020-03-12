<?php declare(strict_types=1);

namespace indigerd\scenarios\validation\validator;

interface ValidatorInterface
{
    public function validate($value, array $context = []) : bool;

    public function getMessage() : string;
}
