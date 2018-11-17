Hands on tutorial instructions part 2
=====================================

Perform search in SearchController
----------------------------------
In SearchController::searchAction the name of the index is retrieved from the
configuration:
```php
    $indexName = $this->app->config['param']['elasticSearch']['index'];
```
Add code below that for searching the index with this name using the query/body
from the QueryBuilder. <br>
[elasticSearch client](https://www.elastic.co/guide/en/elasticsearch/client/php-api/6.0/_search_operations.html)<br>
[Elastica example](../scripts/elastica.php)

Tip: In public/index.php an ElasticSearch or Elastica client has been injected
in the SearchController. 

Test the search page by retrieving public/index.php in your web browser. 
There should not be any errors or exceptions (If you are using the PHP
built in http server, look at its command line output).
It should show a text input for entering a search term,
two selects for filtering by geograpical distance
and another text input for entering a maximum to the average menu price.

Process the search results in the ResultTransformer
---------------------------------------------------
The search page works, but does not show the restaurants we inserted earlier. 

SearchController::searchAction uses a ResultTransformer to convert
the results to parameters for the view:
```php
    $viewParams = $this->resultTransformer->transform($result, $deactivationCounts);
```
To produce the data parameter ResultTransformer::transform calls ::collectHitsSource.
In ::collectHitsSource replace the current implementation by one that returns 
the source of each of the hits.
[documentation and example](https://www.elastic.co/guide/en/elasticsearch/reference/current/_the_search_api.html).



Generate and add a multimatch query
-----------------------------------
The search page does show search results, but whatever you search for, 
the results are the same. We need to tell ElasticSearch what to search 
for and in what fields to look. Implement QueryBuilder::addSearchMultiMatch.
[documentation and example](https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-multi-match-query.html)
To get more results the type should be 'most_fields'.
The fields to look in are specified in config/elasticSearch.php under 'search_fields'.
(The configuration for 'Restaurant' was retrieved by QueryBuilder::construct).
(The example shows the use of a multi match query separately instead of adding the query as a filter 
to a bool query. [Example of adding to a bool](https://www.elastic.co/guide/en/elasticsearch/reference/current/query-filter-context.html)) 

If your implementation works correctly the search page should only return
restaurants from whom the specified fields contain the words searched for.

Generate and add an all aggregation
-----------------------------------
To retrieve how many restaurants there are in the database, implement addAllAggregation
[documentation and example](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-global-aggregation.html)
In the example 'all_products' is the name of the aggregation in the results. 
Use 'total_all' instead.  

Remark: the client does convert an empty array to a json array, not to a json object. 
Pass it a new stdClass to get a json object.

You cannot see the results from the bucket aggregations in the search page yet,
but you may check them with a temporary var_dump in ResultTransformer::transform.

Process meta results
--------------------
The search API of ElasticSearch not only returns what documents were found
(hits) but also some data about the processing and the results
[documentation and example](https://www.elastic.co/guide/en/elasticsearch/reference/current/_the_search_api.html).

ResultTransformer::transformMeta returns some of these and the result of the all aggregation.
Replace the null values by values from $result.

You can see the totals you return in the search page.


[Continue with part 3](Instructions_3.md)