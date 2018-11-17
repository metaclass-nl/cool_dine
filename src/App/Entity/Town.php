<?php

namespace App\Entity;

use App\ValueObject\Coordinates;

/**
 * Class Town
 * @package App\Entity
 */
class Town
{
    /** @var string */
    private $name;
    /** @var Coordinates */
    private $coordinates;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Town
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @param Coordinates $coordinates
     * @return Town
     */
    public function setCoordinates(Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
        return $this;
    }


}