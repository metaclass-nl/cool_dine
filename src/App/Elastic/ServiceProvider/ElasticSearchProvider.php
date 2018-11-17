<?php

namespace App\Elastic\ServiceProvider;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Generic\AbstractServiceProvider;

class ElasticSearchProvider extends AbstractServiceProvider
{

    /** {@inheritdoc} */
    protected function create($args)
    {
        $host = $this->app->config['param']['elasticSearch']['host'];
        $port = $this->app->config['param']['elasticSearch']['port'];

        // implement this
    }
}
