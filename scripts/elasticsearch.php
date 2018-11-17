<?php
/**
 * Code from https://www.elastic.co/guide/en/elasticsearch/client/php-api/6.0/index.html
 */

use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\ElasticsearchException;

require '../vendor/autoload.php';

$indexName = 'my_index';

$hosts = [
    '192.168.0.115:9200',         // IP + Port
];
$client = ClientBuilder::create()
    ->setHosts($hosts)
    ->build();

// Create an index

$params = [
    'index' => $indexName,
    'body' => [
        'settings' => [
            'number_of_shards' => 2,
            'number_of_replicas' => 0
        ],
        'mappings' => [
            '_doc' => [
                'properties' => [
                    'tstamp'  => ['type' => 'date'],
                ]
            ]
        ],
    ],
];

try{
    $response = $client->indices()->create($params);
} catch (ElasticsearchException $ese) {
    print "\n Error when creating index ";
    print_r("\n$ese\n");
}
if (isset($response)) {
    print "\nIndex created: \n";
    print_r($response);
}

// Error handling

$params = [
    'index' => $indexName,
    'type' => '_doc',
    'id' => 'my_id',
    'body' => [
        'testField' => 'abc',
        'tstamp' => '2018-33-33',
    ]
];
try {
    $response = $client->index($params);
} catch (ElasticsearchException $ese) {
    print "\nFailed inserting errorneous document: ". $ese->getMessage(). "\n";
    print "\nError message as array:\n";
    print_r(json_decode($ese->getMessage()));
    print_r("\n$ese\n");
}

// Index a document

$params = [
    'index' => $indexName,
    'type' => '_doc',
    'id' => 'my_id',
    'body' => ['testField' => 'abc']
];

$response = $client->index($params);
print "\nDocument added\n";
print_r($response);

// Get a document

$params = [
    'index' => $indexName,
    'type' => '_doc',
    'id' => 'my_id'
];

$response = $client->get($params);
print "\nDocument retrieved: \n";
print_r($response);

// Wayt for indexing to take place

sleep(2);

// Search for a document

$params = [
    'index' => $indexName,
//    'type' => '_doc',
    'body' => [
        'query' => [
            'match' => [
                'testField' => 'abc'
            ]
        ]
    ]
];

$response = $client->search($params);
print "\nDocument found: \n";
print_r($response);

// Delete a document

$params = [
    'index' => $indexName,
    'type' => '_doc',
    'id' => 'my_id'
];

$response = $client->delete($params);
print "\nDocument deleted: \n";
print_r($response);

// Delete an index

$deleteParams = [
    'index' => $indexName
];
$response = $client->indices()->delete($deleteParams);
print "\nDeleted $indexName: \n";
print_r($response);

