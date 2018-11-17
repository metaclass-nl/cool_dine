<?php

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

use App\Application;
use App\Elastic\ServiceProvider\ElasticSearchProvider;
use App\Elastic\ServiceProvider\ElasticaProvider;
use App\Data\RestaurantSeeds;

require '../vendor/autoload.php';

// Obtain client
$app = new Application();
$clientProv = new ElasticSearchProvider($app);
$client = $clientProv->get();

$indexName = $app->config['param']['elasticSearch']['index'];
deleteIndexIfExists($client, $indexName);

// Create index
$indexConfig = $app->config['elasticSearch']['indexes'][$indexName];
// implement: actually create the index

// Create Normalizer
$encoders = array();
$propertyNormalizers = array(new DateTimeNormalizer(), new ObjectNormalizer());
$propertySerializer = new Serializer($propertyNormalizers, $encoders);
$restaurantNormalizer = new ObjectNormalizer();
$restaurantNormalizer->setSerializer($propertySerializer);
$context = ['attributes' => true ];

// Insert seeds
foreach (RestaurantSeeds::getSeeds() as $restaurant) {
    $data = $restaurantNormalizer->normalize($restaurant, null, $context);

    // implement: make ElasticSearch index the document
}









function deleteIndexIfExists($client, $indexName)
{
    if ($client instanceof \Elasticsearch\Client) {
        if ($client->indices()->exists(['index' => $indexName])) {
            $client->indices()->delete(['index' => $indexName]);
        }
    } else {
        $index = $client->getIndex($indexName);
        if ($index->exists()) {
            $index->delete();
        }
    }
}
