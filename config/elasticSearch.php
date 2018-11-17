<?php
// see https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping.html

$analysis = [
    'filter' => [
        'stemmer_dutch' => [
            'type' => 'stemmer',
            'language' => 'dutch',
        ],
        'ngram_4_10' => [
            'type' => 'ngram',
            'min_gram' => 4,
            'max_gram' => 10,
        ]
    ],
    'analyzer' => [
        'nl_text' => [
            'type' => 'custom',
            'tokenizer' => 'standard',
            'filter' => [ 'lowercase', 'asciifolding', 'stemmer_dutch' ],
        ],
        'nl_text_ngram' => [
            'type' => 'custom',
            'tokenizer' => 'standard',
            'filter' => [ 'lowercase', 'asciifolding', 'ngram_4_10' ],
        ],
        'nl_ngram_search' => [
            'type' => 'custom',
            'tokenizer' => 'lowercase',
            'filter' => [ 'asciifolding' ],
        ],
    ],
];

return [
    'indexes' => [
        $parameters['elasticSearch']['index'] => [
            'settings' => [
                'number_of_shards' => 1,
                'number_of_replicas' => 0,
            ],
            'settings' => [
                'analysis' => $analysis,
            ],
            'mappings' => [
                '_doc' => [
                    'properties' => [
                        // add field mappings here
                    ]
                ]
            ]
        ]
    ],
    'classes' => [
        'Restaurant' => [
            'search_fields' => [
                'name^10',
                'description^3',
                'description.ngram',
                'address',
                'chief',
                'zipcode.code',
                'zipcode.town.name',
            ],
            'option_fields' => [
                'types' => 'Type',
                'diets' => 'Dieet',
                'styles' => 'Stijl',
                'services' => 'Diensten',
            ],
            'range_fields' => [
                'avgMenuPrice' => [
                    'label' => 'Gem. menu prijs',
                    'placeholder' => 'Voer maximum in',
                    'max' => 'lt',
                    // 'min' => 'gte',
                ]
            ]
        ],
    ],
];
