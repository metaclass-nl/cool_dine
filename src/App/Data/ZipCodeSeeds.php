<?php

namespace App\Data;

use App\Entity\ZipCode;
use App\ValueObject\Coordinates;

class ZipCodeSeeds
{
    private static $Seeds;
    /**
     * @return array of ZipCode by code
     */
    public static function getSeeds()
    {
        if (!self::$Seeds) {
            self::createSeeds();
        }
        return self::$Seeds;
    }

    private static function createSeeds()
    {
        self::$Seeds = [];
        $towns = TownSeeds::getSeeds();

        $seed = new ZipCode();
        $seed->setCode('9724 ET')
            ->setCoordinates(new Coordinates(53.2136842, 6.5784830))
            ->setTown($towns['Groningen']);
        self::$Seeds[$seed->getCode()] = $seed;

        $seed = new ZipCode();
        $seed->setCode('9724 GC')
            ->setCoordinates(new Coordinates(53.2148318, 6.5769629))
            ->setTown($towns['Groningen']);
        self::$Seeds[$seed->getCode()] = $seed;

        $seed = new ZipCode();
        $seed->setCode('9711 XB')
            ->setCoordinates(new Coordinates(53.2232421, 6.5700841))
            ->setTown($towns['Groningen']);
        self::$Seeds[$seed->getCode()] = $seed;

        $seed = new ZipCode();
        $seed->setCode('8011 LW')
            ->setCoordinates(new Coordinates(52.5122466, 6.0922865))
            ->setTown($towns['Zwolle']);
        self::$Seeds[$seed->getCode()] = $seed;

        $seed = new ZipCode();
        $seed->setCode('8011 ZZ')
            ->setCoordinates(new Coordinates(52.5155516, 6.0975609))
            ->setTown($towns['Zwolle']);
        self::$Seeds[$seed->getCode()] = $seed;

    }

}