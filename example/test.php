<?php
require '../vendor/autoload.php';
require('../vendor/yiisoft/yii2/Yii.php');

use indigerd\scenarios\Scenario;
use indigerd\scenarios\validation\factory\ValidatorFactory;
use indigerd\scenarios\validation\factory\ValidatorCollectionFactory;

define(YII_DEBUG, true);

class User extends \yii\base\Model
{
    public $user_id;
    public $firstName;
    public $lastName;
}

$rules = [
    ['user_id', 'required'],
    ['user_id', 'integer'],
    ['firstName', 'required']
];

$scenario = new Scenario(new ValidatorFactory(), new ValidatorCollectionFactory(), $rules);

$user = new User();
$user->user_id = 3;
$user->lastName = 'Doe';

try {
    $scenario->validateModel($user);
} catch (\indigerd\scenarios\exception\ModelValidateException $e) {
    print_r($e->getModel()->getErrors());
}