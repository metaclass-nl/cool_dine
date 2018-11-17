<?php

namespace Generic;

/**
 * Class AbstractController
 * @package Generic
 */
abstract class AbstractController
{
    /** @var Application */
    protected $app;

    /** @var string name for including layout
     * WARNING: do not set with data from request or database */
    protected $layout = 'layout';

    /**
     * SearchController constructor.
     * @param Application $app
     */
    function __construct(AbstractApplication $app)
    {
        $this->app = $app;
    }

    /**
     * Render page using layout.php
     * @param string $view path for inlcuding view.
     *     WARNING: do not supply with data from request or database
     * @param array $params
     */
    protected function renderPage($view, $params)
    {
        // Maybe better to use a seperate Renderer class?
        $this->view = '../resources/view/'. $view. '.php';
        $this->renderPiece($this->layout, $params);
    }

    /**
     * Render a view without using layout. Usefull for AJAX
     * @param string $view path for inlcuding view.
     *     WARNING: do not supply with data from request or database
     * @param array $params
     */
    protected function renderPiece($view, $params)
    {
        // Maybe better to use a seperate Renderer class?

        // Put the values from the $params array into local variables
        extract($params);

        include('../resources/view/'. $view. '.php');
    }

}