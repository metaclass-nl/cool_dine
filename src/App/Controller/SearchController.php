<?php

namespace App\Controller;

use App\Elastic\QueryBuilder;
use App\Elastic\ResultTransformer;
use Generic\AbstractController;
use App\Data\TownSeeds;


/**
 * Class SearchController
 * @package App\Controller
 */
class SearchController extends AbstractController
{
    /** @var Client $client */
    private $client;

    /** @var QueryBuilder  */
    private $queryBuilder;

    /** @var ResultTransformer  */
    private $resultTransformer;

    private $distances = [
        '1km', '10km','50km', '100km',
    ];

    /**
     * SearchController constructor.
     * @param \Generic\AbstractApplication $app
     * @param $client
     *
     */
    public function __construct($app, $client, QueryBuilder $queryBuilder, ResultTransformer $resultTransformer)
    {
        parent::__construct($app);

        $this->client = $client;
        $this->queryBuilder = $queryBuilder;
        $this->resultTransformer = $resultTransformer;
    }

    /**
     *
     */
    public function searchAction()
    {
        $searchText = isset($_REQUEST['search_text']) ? $_REQUEST['search_text'] : null;
        $criteria = isset($_REQUEST['criteria']) ? $_REQUEST['criteria'] : [];
        $coordinates = isset($_REQUEST['coordinates']) ? $_REQUEST['coordinates'] : null;
        $distance = isset($_REQUEST['distance']) ? $_REQUEST['distance'] : null;

        $deactivationCounts = $this->retrieveDeactivationCounts($criteria, $searchText, $coordinates, $distance);

        // Create query
        $body = $this->queryBuilder->searchAndFilterBy($criteria, $searchText, $coordinates, $distance)
            ->addAggregations()
            ->getBody();

        // Do search
        $indexName = $this->app->config['param']['elasticSearch']['index'];
        // implement: perform search, assign result to $result

        // transform result
        $viewParams = $this->resultTransformer->transform($result, $deactivationCounts);

        // view needs more parameters
        $viewParams['title'] = 'Cool Dine';
        $viewParams['search_text'] = $searchText;
        $viewParams['coordinates'] = $coordinates;
        $viewParams['distance'] = $distance;
        $viewParams['criteria'] = $criteria;
        $viewParams['towns'] = TownSeeds::getSeeds();
        $viewParams['distances'] = $this->distances;

        // render view
        $this->renderPage('search/main', $viewParams);
    }

    /**
     * Loop through the filter options the user has selected and
     * for each of them retrieve the count for when the user deselects that
     * option.
     * (Only for criteria that are in the option fields)
     * @param array $criteria Active filter options
     * @param string $coordinates
     * @param string $distance
     * @return array [ field => [ option => value, ] ]
     */
    function retrieveDeactivationCounts(array $criteria, $searchText, $coordinates, $distance)
    {
        $optionFields = $this->app->config['elasticSearch']['classes']['Restaurant']['option_fields'];
        $deactivationCounts = [];

        // implement this

        return  $deactivationCounts;
    }
}