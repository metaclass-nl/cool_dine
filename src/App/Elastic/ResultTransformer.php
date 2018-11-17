<?php

namespace App\Elastic;

/**
 * Tranforms search results into view parameters
 * @package App\Elastic
 */
class ResultTransformer
{
    /** @var array */
    private $config;

    /**
     * ResultTransformer constructor.
     * @param array $deactivationCounts [ field => [ option => value, ] ]
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param $result from ElasticSearch
     * @param array $deactivationCounts [ field => [ option => value, ] ]
     * @return array [
     *   'data' => [source, ]
     *   'facets' => [
     *          field => [
     *              [ 'label' => bucket key, 'value => count ],
     *          ]
     *      ],
     *   'meta' => [
     *          'took' => took,
     *          'total_hits' => hits total
     *          'total_all' => all_facets doc_count
     *      ],
     * ]
     */
    public function transform($result, $deactivationCounts)
    {
        /** @var array $aggs [field => [ 'label' => bucket key, 'value => count ], ] */
        $aggs = [];
        /** @var array $stats [ 'label' => ['min' => minimum, 'max' => maximum ], ] */
        $stats = [];

        // implement: Process the results of the bucket aggregations

        return [
            'option_fields' => $this->config['option_fields'],
            'range_fields' => $this->config['range_fields'],
            'facets' => $aggs,
            'stats' => $stats,
            'data' => $this->collectHitsSource($result),
            'meta' => $this->transformMeta($result),
        ];
    }


    /**
     * @param array $result from ElasticSearch
     * @return array [
     *          'took' => took,
     *          'total_hits' => hits total
     *          'total_all' => all_facets doc_count
     *      ]
     */
    private function transformMeta($result)
    {
        // replace the null values by values from $result
        return [
            'took' => null,
            'total_hits' => null,
            'total_all' => null,
        ];
    }

    /**
     * @param array $result from ElasticSearch
     * @return array [source, ] Source from each hit in $result
     */
    private function collectHitsSource($result)
    {
        // replace this
        return [];
    }

    /**
     * Collect bucket keys and doc counts
     * Active filter options may no longer be in the bucket, add them here
     *
     * @param array $buckets
     * @param string $field
     * @param array $item ['buckets' => ['key' => key, 'doc_count' => count], ]
     * @param array $deactivationCounts [ field => [ option => value, ] ]
     * @return array [
     *              [ 'label' => bucket key, 'value => count ],
     *          ]
     */
    private function transformBuckets($field, $item, $deactivationCounts)
    {
        // implement: Collect bucket keys and doc counts

        // implement: add active filter options that are no longer in the aggregations

        return $results;
    }
}
