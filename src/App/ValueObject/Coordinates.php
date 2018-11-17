<?php

namespace App\ValueObject;

/**
 * Geagrapical coordinates
 * @package ValueObject
 */
class Coordinates
{
    /** @var float */
    private $lat;
    /** @var float */
    private $lon;

    /**
     * Coordinates constructor.
     * @param float $lat
     * @param float $lon
     */
    public function __construct($lat, $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     * @return Coordinates
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return float
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * @param float $lon
     * @return Coordinates
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
        return $this;
    }

    /** @return string elasticsearch compatible string */
    public function __toString()
    {
        return "$this->lat, $this->lon";
    }
}