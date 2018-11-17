<?php

namespace App\Elastic\ServiceProvider;

use Elastica\Client;
use Generic\AbstractServiceProvider;

class ElasticaProvider extends AbstractServiceProvider
{
    /** {@inheritdoc} */
    protected function create($args)
    {
        $host = $this->app->config['param']['elasticSearch']['host'];
        $port = $this->app->config['param']['elasticSearch']['port'];

        // implement this
    }
}