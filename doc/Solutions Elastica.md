Solutions for Elastica
======================

(not fully complete, not tested)

These are not necessarily the only possible correct implementations,
they are only meant for if you could not find a working implementation
or want to check your implementation against ours.

Provide a client
----------------
```php
        return new Client([
            'host' => $this->app->config['param']['elasticSearch']['host'],
            'port' => $this->app->config['param']['elasticSearch']['port']
        ]);
```

Create an index
---------------
```php
    $index = $client->getIndex($indexName);
    $index->create($indexConfig);
```

Add documents to the index
--------------------------
```php
    $elasticaType = $index->getType('_doc');
    $document = new \Elastica\Document($restaurant->getId(), $data);
    $document->setType($elasticaType);
    $elasticaType->addDocument($document);
```

Perform search in SearchController
----------------------------------
```php
    $search = new Elastica\Search($elasticaClient);
    $search->addIndex($elasticaIndex);
    $search->setQuery($body);
    $resultSet = $search->search();
    $result = $resultSet->getResponse()->getData();
```

Process the search results in the ResultTransformer
---------------------------------------------------
```php
    return array_map(
            function ($item) {
                return $item['_source'];
            },
            $result['hits']['hits']
        );
```        
(same as with the elasticSearch client)

Generate and add a multimatch query
-----------------------------------
```php
        $multimatch = new Query\MultiMatch();
        $multiMatch->setQuery($term);
        $multiMatch->setFields($fields);
        $multiMatch->setType(Query\MultiMatch::TYPE_MOST_FIELDS);
```        

Generate and add an all aggregation
-----------------------------------
```php
    $this->body->addAggregation(
        new \Elastica\Aggregation\GlobalAggregation('total_all')
    );
```        

Process meta results
--------------------
```php
            'took' => $result['took'],
            'total_hits' => $result['hits']['total'],
            'total_all' => $result['aggregations']['total_all']['doc_count'],
```
(same as with the elasticSearch client)

Add field mappings to the configuration
---------------------------------------
```php
                    'properties' => [
                        'id' => ['type' => 'long'],
                        'name' => ['type' => 'text'],
                        'description' => [
                            'type' => 'text',
                        ],
                        'types' => ['type' => 'keyword'],
                        'diets' => ['type' => 'keyword'],
                        'address' => ['type' => 'text'],
                        'zipcode' => [
                            'type' => 'object',
                            'properties' => [
                                'code' => ['type' => 'keyword'],
                                'coordinates' => ['type' => 'geo_point'],
                                'town' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'name' => ['type' => 'text'],
                                        'coordinates' => ['type' => 'geo_point'],
                                    ],
                                ],
                            ],
                        ],
                        'avgMenuPrice' => ['type' => 'float'],
                        'services' => ['type' => 'keyword'],
                        'chief' => ['type' => 'text'],
                        'score' => ['type' => 'long'],
                        'styles' => ['type' => 'keyword'],
                        'image' => ['type' => 'keyword'],
                    ]
```
(same as with the elasticSearch client)

Specify analyzers and subfields in the mapping
----------------------------------------------
```php
                    'properties' => [
                        'id' => ['type' => 'long'],
                        'name' => ['type' => 'text', 'analyzer' => 'nl_text'],
                        'description' => [
                            'type' => 'text',
                            'analyzer' => 'nl_text',
                            'fields' => [
                                'ngram' => [
                                    'type' => 'text',
                                    'analyzer' => 'nl_text_ngram',
                                    'search_analyzer' => 'nl_ngram_search',
                                ]
                            ],
                        ],
                        'types' => ['type' => 'keyword'],
                        'diets' => ['type' => 'keyword'],
                        'address' => ['type' => 'text', 'analyzer' => 'nl_text'],
                        'zipcode' => [
                            'type' => 'object',
                            'properties' => [
                                'code' => ['type' => 'keyword'],
                                'coordinates' => ['type' => 'geo_point'],
                                'town' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'name' => ['type' => 'text', 'analyzer' => 'nl_text'],
                                        'coordinates' => ['type' => 'geo_point'],
                                    ],
                                ],
                            ],
                        ],
                        'avgMenuPrice' => ['type' => 'float'],
                        'services' => ['type' => 'keyword'],
                        'chief' => ['type' => 'text', 'analyzer' => 'nl_text'],
                        'score' => ['type' => 'long'],
                        'styles' => ['type' => 'keyword'],
                        'image' => ['type' => 'keyword'],
                    ]
```
(same as with the elasticSearch client)

Generate and add bucket aggregations
------------------------------------
```php
        $terms = new \Elastica\Aggregation\Terms($attribute->getName());
        $terms->setField($attribute->getName());

        $this->body->addAggregation($terms);
```

Process the results of the bucket aggregations
==============================================
Make ResultTransformer::transform loop through each of the aggregations ...
```php
        foreach($result['aggregations'] as $field => $item ) {
            if (isset($this->config['option_fields'][$field])) {
                $aggs[$field] = $this->transformBuckets($field, $item, $deactivationCounts);
            }
            // implement: elseif the field is a range field, add to $stats
        }

```
(same as with the elasticSearch client)

Implement ResultTransformer::transformBuckets:
```php
        $results = array_map(
            function ($bucket) use ($field) {
                // implement: check $deactivationCounts ..
                $count = $bucket['doc_count'];
                return [
                    'label' => $bucket['key'],
                    'value' => $count,
                ];
            },
            $item['buckets']
        );

        // implement: add active filter options that are no longer in the aggregations

        return $results;
```
(same as with the elasticSearch client)


Generate and add a term filter for each option
--------------------------------------------
```php
        $term = new \Elastica\Query\Term();
        $term->setTerm($field, $value);

        $this->bool->addFilter($term);
```

Generate and add a range filter 
--------------------------------
```php
        $range = new \ElasticaQuery\Range(
                $field,
                [$comparator => $value]
            );
            
        $this->bool->addFilter($range);
```

Generate and add a geo_distance filter
--------------------------------------
```php
        $distance = new \ElasticaQuery\GeoDistance('zipcode.coordinates', $coordinates, $maxDistance);
        $distance->setDistanceType(Query\GeoDistance::DISTANCE_TYPE_PLANE);

        $this->body->addFilter($distance);
```
(distancesetDistanceType is not required, but DISTANCE_TYPE_PLANE is faster for short distances)

Generate and add stats aggregation queries
------------------------------------------
```php
        $stats = new Aggregation\Stats($field);
        $stats->setField($field);
        
        $this->body->addAggregation($stats);
```

Process the results of the stats aggregation
--------------------------------------------
```php
            elseif (isset($this->config['range_fields'][$field])) {
                $stats[$field] = $item;
            }
```

Query for the number of results when deselecting an option
----------------------------------------------------------
<Yet to be written>

Process the number of results for when deselecting an option
------------------------------------------------------------
```php
    private function transformBuckets($field, $item, $deactivationCounts)
    {
        $result = array_map(
            function ($bucket) use ($field, &$deactivationCounts) {
                if (isset($deactivationCounts[$field][$bucket['key']])) {
                    $count = $deactivationCounts[$field][$bucket['key']];
                    unset($deactivationCounts[$field][$bucket['key']]);
                } else {
                    $count = $bucket['doc_count'];
                }
                return [
                    'label' => $bucket['key'],
                    'value' => $count,
                ];
            },
            $item['buckets']
        );

        // Add active filter options that are no longer in the aggregations
        if (isset($deactivationCounts[$field])) {
            foreach ($deactivationCounts[$field] as $option => $count) {
                array_unshift($result, [
                        'label' => $option,
                        'value' => $count,
                    ]
                );
            }
        }

        return $result;
    }
```
