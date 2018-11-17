<?php

namespace Generic;

/**
 * Class AbstractServiceProvider
 * @package Generic
 */
abstract class AbstractServiceProvider
{
    static $Services;

    /**
     * @var Application
     */
    protected $app;

    public function __construct(AbstractApplication $app)
    {
        $this->app = $app;
    }

    /**
     * Arguments may be supplied depending on the provider implementation
     * @return object Service
     * If the application retrieves the same service multiple times per request
     * This method should let a service container cache the services by name
     */
    public function get()
    {
        // This application only retrieves each service once per request
        return $this->create(func_get_args());
    }

    /**
     * @param array $args function arguments from ::get
     * @return object the requested service
     */
    protected abstract function create($args);

    /**
     * @return string name of the service.
     * Defaults to fully qualified ServiceProvider class name
     * If the application retrieves the same service multiple times per request
     * this method should be overridden for services that are not singletons
     * @param array $args function arguments from ::get
     */
    protected function getName($args)
    {
        return get_class($this);
    }
}