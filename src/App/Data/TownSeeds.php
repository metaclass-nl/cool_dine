<?php

namespace App\Data;

use App\Entity\Town;
use App\ValueObject\Coordinates;

class TownSeeds
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

        $seed = new Town();
        $seed->setName('Groningen')
            ->setCoordinates(new Coordinates(53.217000, 6.581000)); // Groningen Eemskanaal
        self::$Seeds[$seed->getName()] = $seed;

        $seed = new Town();
        $seed->setName('Assen')
            ->setCoordinates(new Coordinates(52.994000, 6.575000)); // Assen Steendijk 	1
        self::$Seeds[$seed->getName()] = $seed;

        $seed = new Town();
        $seed->setName('Zwolle')
            ->setCoordinates(new Coordinates(52.507000, 6.08200)); // Zwolle Willemsvaart 	1
        self::$Seeds[$seed->getName()] = $seed;
    }
}