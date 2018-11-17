<?php

namespace App\Entity;

use App\ValueObject\Coordinates;

/**
 * Class ZipCode
 * @package App\Entity
 */
class ZipCode
{
    /** @var string */
    private $code;
    /** @var Coordinates */
    private $coordinates;
    /** @var Town */
    private $town;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return ZipCode
     */
    public function setCode($code)
    {
        $this->code = $code;
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
     * @return ZipCode
     */
    public function setCoordinates(Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    /**
     * @return Town
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param Town $town
     * @return ZipCode
     */
    public function setTown(Town $town)
    {
        $this->town = $town;
        return $this;
    }


}