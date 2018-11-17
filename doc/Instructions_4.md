Hands on tutorial instructions part 4
=====================================

Generate and add bucket aggregations
------------------------------------
In ::addAggregations the QueryBuilder loops through the fields and config 
of the option fields from the configuration and calls ::addBucketAggregation 
for each of them:
 ```php
    foreach ($this->searchConfig['option_fields'] as $field => $label) {
        $this->addBucketAggregation($query, $field);
    }
 ```

Implement ::addBucketAggregation. 
[documentation and example](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-stats-aggregation.html).
The key 'genres' in the example is the name the aggregation gets in the 
search result. Use $field for this. 

You can't see the results from the bucket aggregations in the search page yet,
but you may check them with a temporary var_dump in ResultTransformer::transform.

Process the results of the bucket aggregations
----------------------------------------------
Make ResultTransformer::transform loop through each of the aggregations in the search result.
If the field is an option field (i.e. is in option_fields in the configuration), 
call ::transformBuckets and put its result in $aggs under the field name
(Remember that you have built the aggregation query to use their names in the search 
result to be the same as the field names).

Implement ResultTransformer::transformBuckets: For each bucket in the buckets of the item,
add an associative array to $results with the key from the bucket under 'label' and the
doc count from the bucket under 'value'.


Generate and add term filter for each option
--------------------------------------------
QueryBuilder::searchAndFilterBy loops through $criteria. 
If the field is an option field it loops trough the options.
If the user has selected the option, it calls ::addOptionFilter:
```php
        foreach ($criteria as $field => $optionsOrValue) {
            if (isset($this->searchConfig['option_fields'][$field])) {
                foreach ($optionsOrValue as $option => $ignored) {
                    $this->addOptionFilter($field, $option);
                }
            } 
```
Implement ::addOptionFilter. Make it generate a term query and add that to the filters
of the bool query. 
[documentation and example](https://www.elastic.co/guide/en/elasticsearch/reference/current/query-filter-context.html)

If your filter works properly look in the search page for a filter option that
has a lower number behind it than the current number of results. Remember that number,
then select the option. This should result in a number of results according to the number
you remembered.

Generate and add a range filter 
--------------------------------
QueryBuilder::searchAndFilterBy loops through $criteria. 
If the field is a range field and the user has entered a value, it calls
::addRangeFilter passing the value under 'max' from the fields configuration:
```php
    } elseif (strlen($optionsOrValue) > 0 && isset($this->searchConfig['range_fields'][$field])) {
        $this->addRangeFilter($field, $optionsOrValue, $this->searchConfig['range_fields'][$field]['max']);
    }
```
Implement ::addRangeFilter. Make it generate a range query and add that to the filters 
of the bool query. 
[documentation and example](https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-range-query.html)
(The example shows the use of a range query separately instead of adding the query as a filter 
to a bool query. [Example of adding it as a filter](https://www.elastic.co/guide/en/elasticsearch/reference/current/query-filter-context.html)) 

If your filter works properly entering a maximum price in the search page should result
in only restaurants with an average menu price below or equal to the maximum.

Generate and add a geo_distance filter
--------------------------------------
Implement :addLocationFilter. It should generate a geo_distance query 
and add it to the filters of the bool query. [documentation and example](https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-distance-query.html).
In the example the query is set directly under 'filters'. We need to be able to add multiple 
filters so you should assume it contains an array with several filters instead.

Tip: The restaurant _doc has an field 'coordinates' that holds an object with another field 'coordinates'.  
Use this instead of pin.location. 

If your filter works properly selecting a city and a distance in the search page should 
result in only restaurants that are writing the selected distance of the center of the 
selected city.  

Generate and add stats aggregation queries
------------------------------------------
QueryBuilder::addAggregations adds two types of aggregations for two kinds of fields: 
Bucket aggregations for option fields, Stats aggregations for range fields.
For the last it calls ::addStatsAggregation. 

Implement ::addStatsAggregation.
[documentation and example](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-stats-aggregation.html).
The key 'grades_stats' in the example is the name the aggregation gets in the 
search result. Use $field for this. 

You can't see the results of the stats aggregation in the search page yet,
but you may check them with a temporary var_dump

Process the results of the stats aggregations
---------------------------------------------

The results of the stats aggregation should now be in the search result, but 
the ResultTransformer doesn't process them yet. Look for the $stats variable
in its :transform method. In the foreach loop below there is the following 
comment:
```php
    // elseif the field is a range field, add to $stats
```
Add code there that, if the field is in the 'range_fields' in the config,
adds an array to $stats under key $field that contains at least keys 'min' and 'max' 
and their values from the stats aggregation. You can find the output of stats aggregations
[here](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-stats-aggregation.html)

If your stats aggregation works properly and is correctly processed by the ResultTransformer
you should in the user interface behind Gem. menu prijs (€ the lowest and highest avarage 
menu price of the selected restaurants.



[Continue with part 5](Instructions_5.md)