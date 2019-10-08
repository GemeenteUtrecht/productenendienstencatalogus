<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Money\Currency;
use Money\Money;

use App\Entity\Product;
use App\Entity\Supplier;
use App\Entity\Group;
use App\Entity\Catalogus;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	// Eerst een de suppliers aanmaken
        $supplier= new Supplier();
        $supplier->setName('Gemeente \'s-Hertogenbosch');
    	$supplier->setKvk('17278704');
    	$manager->persist($supplier);
    	
    	$supplier= new Supplier();
    	$supplier->setName('Gemeente Eindhoven');
    	$supplier->setKvk('17272738');
    	$manager->persist($supplier);
    	
    	$supplier= new Supplier();
    	$supplier->setName('Gemeente Utrecht');
    	$supplier->setKvk('30280353');
    	$manager->persist($supplier);
    	
    	// Catalogi
    	$vng = new Catalogus();
    	$vng->setName('Vereniging Nederlandse Gemeenten');
    	$vng->setRsin('0000');
    	$manager->persist($vng);
    	
    	$denbosch = new Catalogus();
    	$denbosch->setName('Gemeente \'s-Hertogenbosch');
    	$denbosch->setRsin('001709124');
    	$manager->persist($denbosch);
    	
    	$eindhoven= new Catalogus();
    	$eindhoven->setName('Gemeente Eindhoven');
    	$eindhoven->setRsin('001902763');
    	$manager->persist($eindhoven);
    	
    	$utrecht= new Catalogus();
    	$utrecht->setName('Gemeente Utrecht');
    	$utrecht->setRsin('002220647');
    	$manager->persist($utrecht);
    	
    	// Dan wat productgropeen    	
    	$group = new Group();
    	$group->setRsin('001709124'); // 's-Hertogenbosch
    	$group->setName('Burgerzaken');
    	$group->setDescription('Producten en diensten rondom burgerzaken');
    	$group->setCatalogus($denbosch);
    	$manager->persist($group);
    	
    	$group = new Group();
    	$group->setRsin('001902763'); // Eindhoven
    	$group->setName('Burgerzaken');
    	$group->setDescription('Producten en diensten rondom burgerzaken');
    	$group->setCatalogus($eindhoven);
    	$manager->persist($group);    	
    	
    	$trouwproducten = new Group();
    	$trouwproducten->setRsin('002220647'); // Utrecht
    	$trouwproducten->setName('Trouwproducten');
    	$trouwproducten->setDescription('Producten en diensten rondom het trouw proces');
    	$trouwproducten->setCatalogus($utrecht);
    	$manager->persist($trouwproducten);
    	
    	// Producten
    	$trouwen = new Product();
    	$trouwen->setRsin('002220647');
    	$trouwen->setName('Trouwen / Partnerschap');
    	$trouwen->setDescription('Trouwen');
    	$trouwen->setType('set'); 
    	$trouwen->addGroup($trouwproducten);
    	$trouwen->setCatalogus($utrecht);
    	$trouwen->setPrice('627.00');
    	$trouwen->setPriceCurency('EUR');
    	$trouwen->setTaxPercentage(0);
    	$manager->persist($trouwen);
    	
    	
    	$ceremonies = new Group();
    	$ceremonies->setRsin('002220647'); // Utrecht
    	$ceremonies->setName('Ceremonies ');
    	$ceremonies->setDescription('Verschillende cermonies voor uw huwelijk / partnerschap');
    	$ceremonies->setCatalogus($utrecht);
    	$manager->persist($ceremonies);
    	
    	$eenvoudigtrouwen = new Product();
    	$eenvoudigtrouwen->setRsin('002220647');
    	$eenvoudigtrouwen->setName('Eenvoudig trouwen');
    	$eenvoudigtrouwen->setDescription('Eenvoudig trouwen');
    	$eenvoudigtrouwen->setType('set'); 
    	$eenvoudigtrouwen->addGroup($trouwproducten);
    	$eenvoudigtrouwen->addGroup($ceremonies);
    	$eenvoudigtrouwen->setCatalogus($utrecht);
    	$eenvoudigtrouwen->setPrice('163.00');
    	$eenvoudigtrouwen->setPriceCurency('EUR');
    	$eenvoudigtrouwen->setTaxPercentage('0');
    	$manager->persist($eenvoudigtrouwen);
    	
    	$gratistrouwen = new Product();
    	$gratistrouwen->setRsin('002220647');
    	$gratistrouwen->setName('Gratis Trouwen');
    	$gratistrouwen->setDescription('Gratis huwelijk');
    	$gratistrouwen->setType('set'); 
    	$gratistrouwen->addGroup($trouwproducten);
    	$gratistrouwen->addGroup($ceremonies);
    	$gratistrouwen->setCatalogus($utrecht);
    	$gratistrouwen->setPrice('0.00');
    	$gratistrouwen->setPriceCurency('EUR');
    	$gratistrouwen->setTaxPercentage(0);
    	$manager->persist($gratistrouwen);
    	
    	$trouwambtenaar = new Product();
    	$trouwambtenaar->setRsin('002220647');
    	$trouwambtenaar->setName('Trouwambtenaar');
    	$trouwambtenaar->setDescription('En wie gaat u helpen met het ja woord?');
    	$trouwambtenaar->setType('variable'); 
    	$trouwambtenaar->addGroup($trouwproducten);
    	$trouwambtenaar->addGroup($ceremonies);
    	$trouwambtenaar->setCatalogus($utrecht);
    	$trouwambtenaar->setPrice('0.00');
    	$trouwambtenaar->setPriceCurency('EUR');
    	$trouwambtenaar->setTaxPercentage(0);
    	$trouwambtenaar->addSet($trouwen);
    	$trouwambtenaar->addSet($eenvoudigtrouwen);
    	$trouwambtenaar->addSet($gratistrouwen);
    	$manager->persist($trouwambtenaar);
    	
    	$ambtenaar = new Product();
    	$ambtenaar->setRsin('123456789');
    	$ambtenaar->setLogo('https://utrecht.trouwplanner.online/images/content/ambtenaar/erik.jpg');
    	$ambtenaar->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$ambtenaar->setName('Dhr Erik Hendrik');
    	$ambtenaar->setDescription('<p>Als Buitengewoon Ambtenaar van de Burgerlijke Stand geef ik, in overleg met het bruidspaar, invulling aan de huwelijksceremonie.</p>');
    	$ambtenaar->setType('person');
    	$ambtenaar->addGroup($trouwproducten);
    	$ambtenaar->setCatalogus($utrecht);
    	$ambtenaar->setPrice('0.00');
    	$ambtenaar->setPriceCurency('EUR');
    	$ambtenaar->setTaxPercentage(0);
    	$ambtenaar->setParent($trouwambtenaar);
    	$manager->persist($ambtenaar);
    	
    	$ambtenaar = new Product();
    	$ambtenaar->setRsin('123456789');
    	$ambtenaar->setLogo('https://utrecht.trouwplanner.online/images/content/ambtenaar/ike.jpg');
    	$ambtenaar->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$ambtenaar->setName('Mvr Ike van den Pol');
    	$ambtenaar->setDescription('<p>Elkaar het Ja-woord geven, de officiele ceremonie. Vaak is dit het romantische hoogtepunt van de trouwdag. Een bijzonder moment, gedeeld met de mensen die je lief zijn. Een persoonlijke ceremonie, passend bij jullie relatie. Alles is bespreekbaar en maatwerk. Een originele trouwplechtigheid waar muziek, sprekers en kinderen een rol kunnen spelen. Een ceremonie met inhoud, ernst en humor, een traan en een lach, stijlvol, spontaan en ontspannen.</p>');
    	$ambtenaar->setType('person');
    	$ambtenaar->addGroup($trouwproducten);
    	$ambtenaar->setCatalogus($utrecht);
    	$ambtenaar->setPrice('0.00');
    	$ambtenaar->setPriceCurency('EUR');
    	$ambtenaar->setTaxPercentage(0);
    	$ambtenaar->setParent($trouwambtenaar);
    	$manager->persist($ambtenaar);
    	
    	$ambtenaar = new Product();
    	$ambtenaar->setRsin('123456789');
    	$ambtenaar->setLogo('https://utrecht.trouwplanner.online/images/content/ambtenaar/rene.jpg');
    	$ambtenaar->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$ambtenaar->setName('Dhr. Rene Gulje');
    	$ambtenaar->setDescription('<p>Ik ben Rene Gulje, in 1949 in Amsterdam geboren. Ik studeerde Nederlands aan de UVA en journalistiek aan de HU.</p>');
    	$ambtenaar->setType('person');
    	$ambtenaar->addGroup($trouwproducten);
    	$ambtenaar->setCatalogus($utrecht);
    	$ambtenaar->setPrice('0.00');
    	$ambtenaar->setPriceCurency('EUR');
    	$ambtenaar->setTaxPercentage(0);
    	$ambtenaar->setParent($trouwambtenaar);
    	$manager->persist($ambtenaar);
    	
    	$ambtenaar = new Product();
    	$ambtenaar->setRsin('123456789');
    	$ambtenaar->setLogo('https://utrecht.trouwplanner.online/images/content/elements/Trouwambtenaren.png');
    	$ambtenaar->setMovie('https://www.youtube.com/embed/RkBZYoMnx5w');
    	$ambtenaar->setName('Toegewezen Trouwamberbaar');
    	$ambtenaar->setDescription('Uw trouwambtenaar wordt toegewezen, over enkele dagen krijgt u bericht van uw toegewezen trouwambtenaar!');
    	$ambtenaar->setType('simple');
    	$ambtenaar->addGroup($trouwproducten);
    	$ambtenaar->setCatalogus($utrecht);
    	$ambtenaar->setPrice('0.00');
    	$ambtenaar->setPriceCurency('EUR');
    	$ambtenaar->setTaxPercentage(0);
    	$ambtenaar->setParent($trouwambtenaar);
    	$manager->persist($ambtenaar);
    	
    	$ambtenaar = new Product();
    	$ambtenaar->setRsin('123456789');
    	$ambtenaar->setLogo('https://utrecht.trouwplanner.online/images/content/elements/Trouwambtenaren.png');
    	$ambtenaar->setMovie('https://www.youtube.com/embed/RkBZYoMnx5w');
    	$ambtenaar->setName('Zelfgekozen BABS ');
    	$ambtenaar->setDescription('U draagt zelf een trouwambtenaar aan en laat deze voor een dag beedigen');
    	$ambtenaar->setType('simple');
    	$ambtenaar->addGroup($trouwproducten);
    	$ambtenaar->setCatalogus($utrecht);
    	$ambtenaar->setPrice('150.00');
    	$ambtenaar->setPriceCurency('EUR');
    	$ambtenaar->setTaxPercentage(0);
    	$ambtenaar->setParent($trouwambtenaar);
    	$manager->persist($ambtenaar);
    	
    	
    	$locatie= new Product();
    	$locatie->setRsin('002220647');
    	$locatie->setName('Locatie');
    	$locatie->setDescription('Een mooie locatie is goud waard');
    	$locatie->setType('variable');
    	$locatie->addGroup($trouwproducten);
    	$locatie->setCatalogus($utrecht);
    	$locatie->setPrice('0.00');
    	$locatie->setPriceCurency('EUR');
    	$locatie->addSet($trouwen);
    	$locatie->addSet($eenvoudigtrouwen);
    	$locatie->addSet($gratistrouwen);
    	$locatie->setTaxPercentage('0');
    	$manager->persist($locatie);
    	
    	$product = new Product();
    	$product->setRsin('123456789');
    	$product->setLogo('https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/Trouwzaal-Stadskantoor-Utrecht.jpg');
    	$product->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$product->setName('Stadskantoor');
    	$product->setDescription('Deze locatie is speciaal voor eenvoudige en gratis huwelijken.
 De zaal ligt op de 6e etage van het Stadskantoor.
 De ruimte is eenvoudig en toch heel intiem.
 Het licht is in te stellen op een kleur die jullie graag willen.');
    	$product->setType('simple');
    	$product->addGroup($trouwproducten);
    	$product->setCatalogus($utrecht);
    	$product->setPrice('0.00');
    	$product->setPriceCurency('EUR');
    	$product->setTaxPercentage(0);
    	$product->setParent($locatie);
    	$manager->persist($product);
    	
    	$product = new Product();
    	$product->setRsin('123456789');
    	$product->setLogo('https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/kleine-trouwzaal-stadhuis-utrecht.jpg');
    	$product->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$product->setName('Stadhuis kleine zaal');
    	$product->setDescription('Deze uiterst sfeervolle trouwzaal is de droom van ieder koppel');
    	$product->setType('simple');
    	$product->addGroup($trouwproducten);
    	$product->setCatalogus($utrecht);
    	$product->setPrice('0.00');
    	$product->setPriceCurency('EUR');
    	$product->setTaxPercentage(0);
    	$product->setParent($locatie);
    	$manager->persist($product);
    	
    	$product = new Product();
    	$product->setRsin('123456789');
    	$product->setLogo('https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/grote-trouwzaal-stadhuis-utrecht.jpg');
    	$product->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$product->setName('Stadhuis grote zaal');
    	$product->setDescription('Deze uiterst sfeervolle trouwzaal is de droom van ieder koppel');
    	$product->setType('simple');
    	$product->addGroup($trouwproducten);
    	$product->setCatalogus($utrecht);
    	$product->setPrice('0.00');
    	$product->setPriceCurency('EUR');
    	$product->setTaxPercentage(0);
    	$product->setParent($locatie);
    	$manager->persist($product);
    	
    	
    	
    	$trouwboekje = new Product();
    	$trouwboekje->setRsin('002220647');
    	$trouwboekje->setName('Trouwboekje'); 
    	$trouwboekje->setDescription('Een mooi in leer gebonden herindering aan uw huwelijk');
    	$trouwboekje->setType('variable');
    	$trouwboekje->addGroup($trouwproducten);
    	$trouwboekje->setCatalogus($utrecht);
    	$trouwboekje->setPrice('30.20');
    	$trouwboekje->setPriceCurency('EUR');
    	$trouwboekje->setTaxPercentage('0');
        $manager->persist($trouwboekje);
        

        $manager->flush();
    }
}
