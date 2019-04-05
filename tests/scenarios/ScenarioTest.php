<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.08.2018
 * Time: 14:32
 */

namespace indigerd\scenariostests;

use indigerd\scenarios\exception\RequestValidateException;
use indigerd\scenarios\Scenario;
use indigerd\scenarios\validation\factory\ValidatorCollectionFactory;
use indigerd\scenarios\validation\factory\ValidatorFactory;
use indigerd\scenarios\validation\validator\IntegerValidator;
use indigerd\scenarios\validation\validator\RequiredValidator;
use PHPUnit\Framework\TestCase;
use yii\web\Request;

class ScenarioTest extends TestCase
{
    protected $scenario;

    protected function setUp() : void
    {
        $this->scenario = new Scenario(new ValidatorFactory(), new ValidatorCollectionFactory());
    }

    public function testValidateRequest()
    {
        $params = [
            'user_id' => 1,
            'firstName' => 'John',
        ];
        $request = new Request();
        $request->setBodyParams($params);
        $this->scenario->addValidator('user_id', new IntegerValidator());
        $this->scenario->addValidator('user_id', new RequiredValidator());
        $this->scenario->addValidator('firstName', new RequiredValidator());
        $this->assertTrue($this->scenario->validateRequest($request));
    }

    public function testValidateRequestException()
    {
        $this->expectException(RequestValidateException::class);
        $params = [
            'user_id' => 1,
        ];
        $request = new Request();
        $request->setBodyParams($params);
        $this->scenario->addValidator('user_id', new IntegerValidator());
        $this->scenario->addValidator('user_id', new RequiredValidator());
        $this->scenario->addValidator('firstName', new RequiredValidator());
        $this->assertTrue($this->scenario->validateRequest($request));
    }
}
