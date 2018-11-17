<?php

namespace App\Data;

use App\Entity\Restaurant;

class RestaurantSeeds
{
    /** @return array of Restaurant */
    public static function getSeeds()
    {
        $seeds = [];
        $zipcodes = ZipCodeSeeds::getSeeds();

        $seed = new Restaurant();
        $seed->setId(1)
            ->setName('Eetcafe Michel')
            ->setDescription("de Pizzeria van Groningen met o.a. de heerlijkste voorgerechten, vleesgerechten, pizza's en pasta's!")
            ->setAddress('Meeuwerderweg 28')
            ->setAvgMenuPrice(26.0)
            ->setScore(8)
            ->setImage('http://eetcafemichel.nl/images/delicious-too-1327394.jpg?crc=164879595')
            ->setTypes(['italiaans'])
            ->setDiets(['vegetarisch'])
            ->setStyles(['vrienden', 'terras'])
            ->setZipcode($zipcodes['9724 ET']);
        $seeds[] = $seed;

        $seed = new Restaurant();
        $seed->setId(2)
            ->setName('Taj Mahal')
            ->setDescription("Indiaas Restaurant Taj Mahal is een familiebedrijf, dat aan de Veemarktstraat in de Oosterpoort is gevestigd en naam heeft gemaakt met haar bediening, kwaliteit en kwantiteit van de gerechten. Na binnenkomst wordt u ontvangen door een aangename geur en een zeer gastvrije bediening. Na binnenkomst wordt u ontvangen door een aangename geur en een zeer gastvrije bediening.")
            ->setAddress('Veemarktstraat 94')
            ->setAvgMenuPrice(24.0)
            ->setScore(7)
            ->setImage('http://www.tajmahalgroningen.nl/img/fotos/4.JPG')
            ->setTypes(['indiaas'])
            ->setDiets(['vegetarisch', 'glutenvrij', 'lactose intolerantie', 'pinda-allergie', 'noten-allergie'])
            ->setStyles(['vrienden', 'terras'])
            ->setZipcode($zipcodes['9724 GC']);
        $seeds[] = $seed;

        $seed = new Restaurant();
        $seed->setId(3)
            ->setName('Voilà')
            ->setDescription("Bij Voilà, uw (h)eerlijke restaurant in Groningen, kunt u terecht voor een diner volgens het Franse table d’hôte principe. Wij serveren een dagelijks wisselend vijfgangenmenu voor € 45,00. Met de Franse keuken als basis kookt onze keukenbrigade gerechten met elke dag (h)eerlijke verse producten.")
            ->setAddress('W.A. Scholtenstraat 39')
            ->setAvgMenuPrice(45.0)
            ->setScore(9)
            ->setImage('http://www.restaurantvoila.nl/uploads/uitgelicht-home/restaurant_voila6.jpg')
            ->setTypes(['frans'])
            ->setDiets(['vegetarisch', 'biologisch', 'glutenvrij', 'lactose intolerantie', 'pinda-allergie'])
            ->setStyles(['romantisch', 'terras', 'bistro'])
            ->setServices(['wifi', 'wijnarrrangement',])
            ->setChief('Hans Over')
            ->setZipcode($zipcodes['9711 XB']);
        $seeds[] = $seed;

        $seed = new Restaurant();
        $seed->setId(4)
            ->setName('De Librije')
            ->setDescription("Jonnie Boer werd op vierentwintigjarige leeftijd chef-kok bij Restaurant De Librije in Zwolle. Enkele jaren later, in 1993, kocht hij samen met zijn echtgenote Thérèse, vinologe en gastvrouw, het restaurant. In 1993 verkreeg de Librije de eerste Michelinster. In 1999 volgde de tweede ster. Daarmee was Boer de jongste tweesterrenkok in Nederland. In 2004 was De Librije het tweede restaurant in Nederland dat een derde ster krijgt. ")
            ->setAddress('Spinhuisplein 1')
            ->setAvgMenuPrice(185.0)
            ->setScore(9)
            ->setImage('https://www.librije.com/wp-content/uploads/2014/12/Restaurant-De-Librije-300x200.jpg')
            ->setTypes(['hollands'])
            ->setDiets(['biologisch', 'glutenvrij', 'lactose intolerantie', 'noten-allergie', 'vegetarisch'])
            ->setStyles(['romantisch', 'zakenlunch', 'terras'])
            ->setServices(['wifi', 'airco', 'wijnarrrangement',])
            ->setChief('Jonnie Boer & Maik Kuijpers')
            ->setZipcode($zipcodes['8011 ZZ']);
        $seeds[] = $seed;

        $seed = new Restaurant();
        $seed->setId(5)
            ->setName('La Meridiana')
            ->setDescription("Beleef het authentieke Italiaanse eten van La Meridiana. Met een uniek uitzicht op de Grote Markt serveren wij u onze gerechten voornamelijk geïnspireerd op de keuken van de regio Emilia Romagna. Buon Appetito!")
            ->setAddress('GROTE MARKT 11A')
            ->setAvgMenuPrice(39)
            ->setScore(7)
            ->setImage('http://www.lameridiana.nl/login/uploads/image/2000p-avond/voorgerecht2-1200x800.jpg')
            ->setTypes(['italiaans'])
            ->setDiets(['glutenvrij', 'lactose intolerantie', 'glutenvrij'])
            ->setStyles(['romantisch', 'zakenlunch', 'kindvriendelijk', 'terras'])
            ->setServices(['invalidentoilet'])
            ->setChief('')
            ->setZipcode($zipcodes['8011 LW']);
        $seeds[] = $seed;

        return $seeds;
    }
}