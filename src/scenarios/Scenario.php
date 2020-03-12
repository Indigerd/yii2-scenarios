<?php declare(strict_types=1);

namespace indigerd\scenarios;

use indigerd\scenarios\validation\validator\ValidatorInterface;
use yii\base\Model;
use yii\web\Request;
use indigerd\scenarios\exception\ModelValidateException;
use indigerd\scenarios\exception\RequestValidateException;
use indigerd\scenarios\validation\factory\ValidatorFactory;
use indigerd\scenarios\validation\factory\ValidatorCollectionFactory;

class Scenario
{
    protected $validatorFactory;

    protected $validatorCollectionFactory;

    protected $attributes = [];

    public function __construct(
        ValidatorFactory $validatorFactory,
        ValidatorCollectionFactory $validatorCollectionFactory,
        array $validationRules = []
    ) {
        $this->validatorFactory = $validatorFactory;
        $this->validatorCollectionFactory = $validatorCollectionFactory;
        foreach ($validationRules as $rule) {
            if (!\is_array($rule) or \sizeof($rule) < 2) {
                throw new \InvalidArgumentException('Invalid rule configuration');
            }
            $this->addValidationRule(...$rule);
        }
    }

    public function addValidationRule($attribute, $validator, array $params = []) : self
    {
        $attributes = \is_array($attribute) ? $attribute : [$attribute];
        foreach ($attributes as $attributeName) {
            if (!($validator instanceof ValidatorInterface)) {
                $validator = $this->validatorFactory->create($validator, $params);
            }
            $this->addValidator($attributeName, $validator);
        }
        return $this;
    }

    public function addValidator($attribute, ValidatorInterface $validator) : self
    {
        if (!isset($this->attributes[$attribute])) {
            $this->attributes[$attribute] = $this->validatorCollectionFactory->create();
        }
        $this->attributes[$attribute]->addValidator($validator);
        return $this;
    }

    public function validateModel(Model $model) : bool
    {
        $context = $model->toArray();
        foreach ($this->attributes as $attribute => $validatorCollection) {
            if (!$validatorCollection->validate($model->$attribute, $context)) {
                foreach ($validatorCollection->getMessages() as $message) {
                    $model->addError($attribute, $message);
                }
            }
        }
        if ($model->hasErrors()) {
            throw new ModelValidateException($model);
        }
        return true;
    }

    public function validateRequest(Request $request, string $variables = 'body') : bool
    {
        $errors = [];
        $context = ($variables == 'body' ? $request->getBodyParams() : $request->getQueryParams());
        foreach ($this->attributes as $attribute => $validatorCollection) {
            $value = isset($context[$attribute]) ? $context[$attribute] : null;
            if (!$validatorCollection->validate($value, $context)) {
                foreach ($validatorCollection->getMessages() as $message) {
                    $errors[$attribute][] = $message;
                }
            }
        }
        if (\sizeof($errors) > 0) {
            throw new RequestValidateException($request, $errors);
        }
        return true;
    }
}
