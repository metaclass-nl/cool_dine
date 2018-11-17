<?php

namespace App\Elastic\ServiceProvider;


use App\Elastic\ResultTransformer;
use Generic\AbstractServiceProvider;

class ResultTransformerProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     * @param $args array(entityName)
     */
    protected function create($args)
    {
        return new ResultTransformer($this->app->config['elasticSearch']['classes'][$args[0]]);;
    }
}