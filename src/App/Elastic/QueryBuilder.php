<?php

namespace App\Elastic;

use Generic\AbstractApplication;

/**
 * Class QueryBuilder
 * @package App\Elastic
 */
class QueryBuilder
{
    /** @var array */
    private $indexConfig;
    /** @var array */
    private $searchConfig;

    /** @var array with search parameters body
     * If you use Elastica: Elastica\Query */
    private $body;
    /** @var array with bool
     * If you use Elastica: Elastica\Query\BoolQuery */
    private $bool;

    /**
     * QueryFactory constructor.
     * @param array $indexConfig Configuration of the index to use
     * @param array $searchConfig Type-specific configuration of the search
     */
    public function __construct(AbstractApplication $app, $indexName, $entityName)
    {
        $this->indexConfig = $app->config['elasticSearch']['indexes'][$indexName];
        $this->searchConfig = $app->config['elasticSearch']['classes'][$entityName];
        $this->clear();
    }

    public function clear()
    {
        $this->body = [];
        // Elastica: new \Elastica\Query();

        $this->bool = [];
        // Elastica: $bool = new \Elastica\Query\BoolQuery();
    }

    /**
     * https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-query.html
     *
     * @param array $criteria
     * @param string $searchTerm
     * @param string $coordinates
     * @param string $maxDistance
     * @return $this
     */
    public function searchAndFilterBy($criteria, $searchTerm, $coordinates, $maxDistance)
    {
        $this->clear();

        // Filter by $criteria
        foreach ($criteria as $field => $optionsOrValue) {
            if (isset($this->searchConfig['option_fields'][$field])) {
                foreach ($optionsOrValue as $option => $ignored) {
                    $this->addOptionFilter($field, $option);
                }
            } elseif (strlen($optionsOrValue) > 0 && isset($this->searchConfig['range_fields'][$field])) {
                $this->addRangeFilter($field, $optionsOrValue, $this->searchConfig['range_fields'][$field]['max']);
            }
        }

        // Search
        if (strlen($searchTerm) > 0) {
            $this->addSearchMultiMatch($searchTerm);
        }

        // Distance
        if (strlen($maxDistance) > 0 && !empty($coordinates)) {
            $this->addLocationFilter($coordinates, $maxDistance);
        }

        return $this;
    }

    /**
     * @return array with search parameters body
     * If you use Elastica: Elastica\Query
     */
    public function getBody()
    {
        if (!empty($this->bool)) {
            $this->body['query'] = ['bool' => $this->bool];
        }
        // Elastica:
        // if (is_array($this->bool->toArray())  {
        //     $this->body->setQuery($this->bool);
        // }

        return $this->body;
    }

    /**
     * @return $this
     */
    public function addAggregations()
    {
        $this->addAllAggregation();

        foreach ($this->searchConfig['option_fields'] as $field => $label) {
            $this->addBucketAggregation($field);
        }
        foreach ($this->searchConfig['range_fields'] as $field => $config) {
            $this->addStatsAggregation($field);
        }

        return $this;
    }

    // Idea: make more methods public and to allow fine grained control over query generation.
    // Let them return $this for a fluent api

    /**
     * If you use Elastica adds Elastica\Query\Term as filter
     * https://www.elastic.co/guide/en/elasticsearch/reference/current/query-filter-context.html
     *
     * @param string $field
     * @param string $value
     */
    private function addOptionFilter($field, $value)
    {
        // implement this
    }

    /**
     * If you use Elastica adds Elastica\Query\Range as filter
     * https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-range-query.html
     *
     * @param string $field
     * @param mixed $value
     * @param string $comparator
     */
    private function addRangeFilter($field, $value, $comparator)
    {
        // implement this
    }

    /**
     * https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-multi-match-query.html
     * @param string $term
     */
    private function addSearchMultiMatch($term)
    {
        $fields = $this->searchConfig['search_fields'];

        // complete this
    }

   /**
     * If you use Elastica this adds a Elastica\Aggregation\GlobalAggregation
     * https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-global-aggregation.html
     */
    private function addAllAggregation()
    {
        // implement this
    }

    /**
     * If you use Elastica this adds a Elastica\Aggregation\Terms for each aggregation field in $this->searchConfig
     * https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-terms-aggregation.html

     * @param string $field
     */
    private function addBucketAggregation($field)
    {
        // implement this
    }

    /**
     * If you use Elastica this adds a Elastica\Aggregation\Stats for each range field in $this->searchConfig
     * https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-stats-aggregation.html

     * @param string $field
     */
    private function addStatsAggregation($field)
    {
        // implement this
    }

    /**
     * If you use Elastica this adds a Elastica\Query\GeoDistance as filter
     * see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-distance-query.html
     *
     * @param string $coordinates lat, lon
     * @param $maxDistance
     */
    private function addLocationFilter($coordinates, $maxDistance)
    {
        // implement this
    }

}