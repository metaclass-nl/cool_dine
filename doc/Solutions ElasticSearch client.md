Solutions for the ElasticSearch client
======================================

These are not necessarily the only possible correct implementations,
they are only meant for if you could not find a working implementation
or want to check your implementation against ours.

Provide a client
----------------
```php
        return ClientBuilder::create()
            ->setHosts(["$host:$port"])
            ->build();
```

Create an index
---------------
```php
    $client->indices()->create(['index' => $indexName, 'body' => $indexConfig]);
```

Add documents to the index
--------------------------
```php
    $params = [
        'index' => $indexName,
        'type'  => '_doc',
        'id'    => $restaurant->getId(),
        'body'  => $data,
    ];
    $client->index($params);
```

Perform search in SearchController
----------------------------------
```php
    $params = [
                'index' => $indexName,
                'type' => '_doc',
                'body' => $body,
            ];
    $result = $this->client->search($params);
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

Generate and add a multimatch query
-----------------------------------
```php
        $this->bool['must'][] = [
            'multi_match' => [
                'query' => $term,
                'fields' => $fields,
                'type' => 'most_fields',
            ]
        ];
```        

Generate and add an all aggregation
-----------------------------------
```php
        $this->body['aggs']['total_all']['global'] = new \stdClass();
```        

Process meta results
--------------------
```php
            'took' => $result['took'],
            'total_hits' => $result['hits']['total'],
            'total_all' => $result['aggregations']['total_all']['doc_count'],
```

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

Generate and add bucket aggregations
------------------------------------
```php
        $this->body['aggs'][$field] = [
            'terms' => ['field' => $field]
        ];
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

Generate and add a term filter for each option
--------------------------------------------
```php
        $this->bool['filter'][] = [
            'term' => [$field => $value]
        ];

```

Generate and add a range filter 
--------------------------------
```php
        $this->bool['filter'][] = [
            'range' => [
                $field => [$comparator => $value],
            ]
        ];
```

Generate and add a geo_distance filter
--------------------------------------
```php
        $this->bool['filter'][] = [
            'geo_distance' => [
                'distance' => $maxDistance,
                'zipcode.coordinates' => $coordinates,
                'distance_type' => 'plane',
            ]
        ];
```
(distance_type is not required, but is faster for short distances)

Generate and add stats aggregation queries
------------------------------------------
```php
        $this->body['aggs'][$field] = [
            'stats' => ['field' => $field]
        ];
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
```php
        foreach ($criteria as $field => $options) {
            if (isset($optionFields[$field])) {
                foreach ($options as $option => $value) {
                    $copy = $criteria; // create a copy
                    unset($copy[$field][$option]);
                    $body = $this->queryBuilder
                        ->searchAndFilterBy($copy, $searchText, $coordinates, $distance)
                        ->getBody();
                    $params = [
                        'index' => $this->app->config['param']['elasticSearch']['index'],
                        'type' => '_doc',
                        'body' => $body,
                    ];
                    $result = $this->client->count($params);
                    $deactivationCounts[$field][$option] = $result['count'];
                }
            }
        }
```

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