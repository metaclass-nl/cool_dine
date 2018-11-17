<?php

namespace App\Entity;

/**
 * Class Restaurant
 * @package App\Entity
 */
class Restaurant
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $description;
    /** @var array of string (frans, italiaans, chinees, spaans, internationaal, nederlands) */
    private $types;
    /** @var array of string (lactose intolerantie, glutenvrij, vegetarisch, pinda-allergie, noten-allergie)*/
    private $diets;
    /** @var string */
    private $address;
    /** @var ZipCode - ES does not work with member name zipCode */
    private $zipcode;
    /** @var float */
    private $avgMenuPrice;
    /** @var array of string (wifi, airco, wijnarrrangement, invalidentoilet) */
    private $services;
    /** @var string */
    private $chief;
    /** @var int */
    private $score;
    /** @var array of string (familie, vrienden, zakenlunch, romantisch, terras, kindvriendelijk, tuin) */
    private $styles;
    /** @var string url of image */
    private $image;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Restaurant
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Restaurant
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Restaurant
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param array $types
     * @return Restaurant
     */
    public function setTypes($types)
    {
        $this->types = $types;
        return $this;
    }

    /**
     * @return array
     */
    public function getDiets()
    {
        return $this->diets;
    }

    /**
     * @param array $diets
     * @return Restaurant
     */
    public function setDiets($diets)
    {
        $this->diets = $diets;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return Restaurant
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return ZipCode
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param ZipCode $zipCode
     * @return Restaurant
     */
    public function setZipcode(ZipCode $zipCode)
    {
        $this->zipcode = $zipCode;
        return $this;
    }

    /**
     * @return float
     */
    public function getAvgMenuPrice()
    {
        return $this->avgMenuPrice;
    }

    /**
     * @param float $avgMenuPrice
     * @return Restaurant
     */
    public function setAvgMenuPrice($avgMenuPrice)
    {
        $this->avgMenuPrice = $avgMenuPrice;
        return $this;
    }

    /**
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param array $services
     * @return Restaurant
     */
    public function setServices($services)
    {
        $this->services = $services;
        return $this;
    }

    /**
     * @return string
     */
    public function getChief()
    {
        return $this->chief;
    }

    /**
     * @param string $chief
     * @return Restaurant
     */
    public function setChief($chief)
    {
        $this->chief = $chief;
        return $this;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param int $score
     * @return Restaurant
     */
    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @return array
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * @param array $styles
     * @return Restaurant
     */
    public function setStyles($styles)
    {
        $this->styles = $styles;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Restaurant
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }


}