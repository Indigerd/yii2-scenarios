<?php

namespace indigerd\scenarios\validation\factory;

use indigerd\scenarios\validation\collection\ValidatorCollection;
use indigerd\scenarios\validation\validator\ValidatorInterface;

class ValidatorCollectionFactory
{
    public function create(ValidatorInterface ...$validators) : ValidatorCollection
    {
        return new ValidatorCollection(...$validators);
    }
}
