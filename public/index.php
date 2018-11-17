<?php

use App\Application;
use App\Elastic\ServiceProvider\ElasticSearchProvider;
use App\Elastic\ServiceProvider\ElasticaProvider;
use App\Elastic\QueryBuilder;
use App\Elastic\ServiceProvider\ResultTransformerProvider;
use App\Controller\SearchController;

require '../vendor/autoload.php';

// Create dependencies to be injected
$app = new Application();
$clientProv = new ElasticSearchProvider($app);
$transformerProv = new ResultTransformerProvider($app);
$indexName = $app->config['param']['elasticSearch']['index'];
$queryBuilder = new QueryBuilder($app, $indexName, 'Restaurant');

// Create controller

$controller = new SearchController(
    $app,
    $clientProv->get(),
    $queryBuilder,
    $transformerProv->get('Restaurant')
);

// Perform controller action
$controller->searchAction();