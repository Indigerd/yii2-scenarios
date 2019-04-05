<?php

namespace indigerd\scenariostests\validation\factory;

use indigerd\scenarios\validation\collection\ValidatorCollection;
use PHPUnit\Framework\TestCase;
use indigerd\scenarios\validation\factory\ValidatorCollectionFactory;

class ValidatorCollectionFactoryTest extends TestCase
{
    protected $factory;

    protected function setUp() : void
    {
        $this->factory = new ValidatorCollectionFactory();
    }

    public function testCreateInvalidParams()
    {
        $this->expectException(\TypeError::class);
        $this->factory->create('params');
    }

    public function testCreate()
    {
        $collection = $this->factory->create();
        $this->assertInstanceOf(ValidatorCollection::class, $collection);
    }
}
