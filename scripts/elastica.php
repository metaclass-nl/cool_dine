<?php
/**
 * Code from http://elastica.io/getting-started/storing-and-indexing-documents.html
 * adapted to ElasticSearch 6
 */

use Elastica\Client;

require_once '../vendor/autoload.php';

$elasticaClient = new \Elastica\Client(array(
    'host' => '192.168.0.115',
    'port' => 9200
));

// Load index
$elasticaIndex = $elasticaClient->getIndex('twitter');

// Create the index new
// default_index replaced by default
// type 'string' replaced by 'text'
//  include_in_all removed
// mappings included instead of using Elastica\Type\Mapping

$response = $elasticaIndex->create(
    array(
        'number_of_shards' => 1,
        'number_of_replicas' => 0,
        'analysis' => array(
            'analyzer' => array(
                'default' => array(
                    'type' => 'custom',
                    'tokenizer' => 'standard',
                    'filter' => array('lowercase', 'mySnowball')
                ),
                'default_search' => array(
                    'type' => 'custom',
                    'tokenizer' => 'standard',
                    'filter' => array('standard', 'lowercase', 'mySnowball')
                )
            ),
            'filter' => array(
                'mySnowball' => array(
                    'type' => 'snowball',
                    'language' => 'German'
                )
            )
        ),
        'mappings' => [
            'tweet' => [
                'properties' => [
                    'id'      => ['type' => 'integer'], //, 'include_in_all' => FALSE),
                    'user'    => [
                        'type' => 'object',
                        'properties' => [
                            'name'      => array('type' => 'text'),
                            'fullName'  => array('type' => 'text', 'boost' => 2)
                        ],
                    ],
                    'msg'     => ['type' => 'text'],
                    'tstamp'  => ['type' => 'date'],
                    'location'=> ['type' => 'geo_point']
                ],
            ],
        ],
    ),
    true
);


//Create a type
$elasticaType = $elasticaIndex->getType('tweet');

// The Id of the document
$id = 1;

// Create a document
$tweet = array(
    'id'      => $id,
    'user'    => array(
        'name'      => 'mewantcookie',
        'fullName'  => 'Cookie Monster'
    ),
    'msg'     => 'Me wish there were expression for cookies like there is for apples. "A cookie a day make the doctor diagnose you with diabetes" not catchy.',
    'tstamp'  => '1238081389',
    'location'=> '41.12,-71.34'
);
// First parameter is the id of document.
$tweetDocument = new \Elastica\Document($id, $tweet);
$tweetDocument->setType($elasticaType);

// Add tweet to type
$response = $elasticaType->addDocument($tweetDocument);

print "\nDocument added\n";

// Refresh Index
$elasticaType->getIndex()->refresh();

print "\nIndex refreshed\n";

// Retrieve tweet
$search = new Elastica\Search($elasticaClient);
$search->addIndex($elasticaIndex);
$query = new Elastica\Query\Range('tstamp', ["gte" => '1970-01-13T14:41:50+00:00']);

$search->setQuery($query);
$resultSet = $search->search();
$result = $resultSet->getResponse()->getData();
print_r($result);