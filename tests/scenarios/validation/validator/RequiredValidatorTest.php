<?php

namespace indigerd\scenariostests\validation\validator;

use indigerd\scenarios\validation\validator\RequiredValidator;
use PHPUnit\Framework\TestCase;

class RequiredValidatorTest  extends TestCase
{
    protected $validator;

    protected $constructorErrorMessage = 'Test message';

    protected function setUp() : void
    {
        $this->validator = new RequiredValidator(['message' => $this->constructorErrorMessage]);
    }

    public function testSetMessage()
    {
        $this->assertEquals($this->constructorErrorMessage, $this->validator->getMessage());
        $message = 'Custom message';
        $this->validator->setMessage($message);
        $this->assertEquals($message, $this->validator->getMessage());
    }

    public function testValidate()
    {
        $this->assertTrue($this->validator->validate(1));
        $this->assertTrue($this->validator->validate('str'));
        $this->assertFalse($this->validator->validate(''));
        $this->assertFalse($this->validator->validate([]));
    }
}
