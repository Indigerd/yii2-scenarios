<?php

namespace indigerd\scenarios\filters;

use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\base\InvalidConfigException;
use yii\web\Request;
use yii\web\Response;
use indigerd\scenarios\Scenario;
use indigerd\scenarios\exception\RequestValidateException;
use indigerd\scenarios\validation\factory\ValidatorCollectionFactory;
use indigerd\scenarios\validation\factory\ValidatorFactory;

class RequestFilter extends ActionFilter
{
    public $filters = [];

    /**
     * @var Request the current request. If not set, the `request` application component will be used.
     */
    public $request;

    /**
     * @var Response the response to be sent. If not set, the `response` application component will be used.
     */
    public $response;

    public $validatorFactory;

    public $validatorCollectionFactory;


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if ($this->request === null) {
            $this->request = Yii::$app->getRequest();
        }
        if ($this->response === null) {
            $this->response = Yii::$app->getResponse();
        }
        if ($this->validatorFactory === null) {
            $this->validatorFactory = ValidatorFactory::class;
        }
        if ($this->validatorCollectionFactory === null) {
            $this->validatorCollectionFactory = ValidatorCollectionFactory::class;
        }
        foreach ($this->filters as $action => $filter) {
            if ($filter instanceof Scenario) {
                continue;
            }
            $scenario = '';
            $rules    = [];
            if (is_string($filter)) {
                $scenario = $filter;
            }
            if (is_array($filter)) {
                if (!isset($filter['class'])) {
                    throw new InvalidConfigException('Invalid request filters configuration');
                }
                $scenario = $filter['class'];
                $rules = isset($filter['rules']) ? $filter['rules'] : [];
            }
            if (!is_a($scenario, Scenario::class, true)) {
                throw new InvalidConfigException('Invalid request filters configuration');
            }

            $this->filters[$action] = new $scenario(
                new $this->validatorFactory,
                new $this->validatorCollectionFactory,
                $rules
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeAction(Action $action)
    {
        if ($this->request->getIsHead() or $this->request->getIsOptions()) {
            return true;
        }
        if (isset($this->filters[$action->id])) {
            try {
                /** @var Scenario $scenario */
                $scenario = $this->filters[$action->id];
                $scenario->validateRequest(
                    $this->request,
                    ($this->request->getIsGet() ? 'query' : 'body')
                );
            } catch (RequestValidateException $e) {
                $this->response->data = $e->getErrorCollection();
                $this->response->setStatusCode(422, 'Request validation failed');
                return false;
            }
        }
        return true;
    }
}
