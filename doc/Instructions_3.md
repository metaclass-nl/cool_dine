Hands on tutorial instructions part 3
=====================================

Add field mappings to the configuration
---------------------------------------
In the second next instruction we will generate and add bucket aggregations to 
retrieve which filter options are available in the search result. By default
ElasticSearch indexes textual values for free text search. Our problem is that it can 
normally not use text values for bucket aggregations. We need to map those fields as
type 'keyword'. 

Furthermore ElasticSearch does not automatically recognize Geo Coordinates. 
If the fields holding coordinates are not mapped as type 'geo_point' ElasticSearch 
can not filter by distance.

Add field mappings to the configuration in config/elasticSearch.php in the array under 'properties'.
[documentation and example](https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping.html).
Which fields to map and their types in PHP can be found in src/App/Entity/Restaurant.php
Which fields are option fields can be found in config/elasticSearch.phpunder 'option_fields'.

You may run into problems with the property 'zipcode': It contains another Entity! 
The Normalizer will convert that entity to an array and put it in the field 'zipcode'.
[documentation and example](https://www.elastic.co/guide/en/elasticsearch/reference/current/object.html)

After you have implemented the mapping you need to re-generate the index. At 
the scripts folder do:
```bash
php createSeedIndex.php
```

Specify analyzers and subfields in the mapping
----------------------------------------------
You may have noticed that searching for whole words works fine, but searching for
parts of words yields no results. This is problematic for languages like Dutch,
where words can be concatenated, like 'familiebedrijf'. In english this would be
'family business' so that this problem would not occur. We need to tell ElasticSearch
how to index the fields we want to search. The configuration already defines analyzers
for this: 
```php
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
```
Add 'analyzer' specifications for text fields to the mapping using nl_text. Example:
```php
                    'properties' => [
                        'name' => ['type' => 'text', 'analyzer' => 'nl_text'],
```

For the field 'description' add a sub field 'ngram' of type 'text' with analyzer 'nl_text_ngram'
and search_analyzer 'nl_ngram_search'. 
[documentation and example](https://www.elastic.co/guide/en/elasticsearch/reference/current/multi-fields.html)

After re-generating the index you should be able to find a restaurant when 
searching for 'familie'.



[Continue with part 4](Instructions_4.md)