<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Money\Currency;
use Money\Money;

use App\Entity\Product;
use App\Entity\Supplier;
use App\Entity\Group;
use App\Entity\Catalogue;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	// Eerst een de suppliers aanmaken
        $supplier= new Supplier();
        $supplier->setName('Gemeente \'s-Hertogenbosch');
        $supplier->setSourceOrganization('001709124');
    	$supplier->setKvk('17278704');
    	$manager->persist($supplier);
    	
    	$supplier= new Supplier();
    	$supplier->setName('Gemeente Eindhoven');
    	$supplier->setSourceOrganization('001902763');
    	$supplier->setKvk('17272738');
    	$manager->persist($supplier);
    	
    	$supplier= new Supplier();
    	$supplier->setName('Gemeente Utrecht');
    	$supplier->setSourceOrganization('002220647');
    	$supplier->setKvk('30280353');
    	$manager->persist($supplier);
    	
    	// Catalogi
    	$vng = new Catalogue();
    	$vng->setName('Vereniging Nederlandse Gemeenten');
    	$vng->setSourceOrganization('0000');
    	$manager->persist($vng);
    	
    	$denbosch = new Catalogue();
    	$denbosch->setName('Gemeente \'s-Hertogenbosch');
    	$denbosch->setSourceOrganization('001709124');
    	$manager->persist($denbosch);
    	
    	$eindhoven= new Catalogue();
    	$eindhoven->setName('Gemeente Eindhoven');
    	$eindhoven->setSourceOrganization('001902763');
    	$manager->persist($eindhoven);
    	
    	$utrecht= new Catalogue();
    	$utrecht->setName('Gemeente Utrecht');
    	$utrecht->setSourceOrganization('002220647');
    	$manager->persist($utrecht);
    	
    	// Dan wat productgroepen    	
    	$group = new Group();
    	$group->setSourceOrganization('001709124'); // 's-Hertogenbosch
    	$group->setName('Burgerzaken');
    	$group->setDescription('Producten en diensten binnen burgerzaken');
    	$group->setCatalogue($denbosch);
    	$manager->persist($group);
    	
    	$group = new Group();
    	$group->setSourceOrganization('001902763'); // Eindhoven
    	$group->setName('Burgerzaken');
    	$group->setDescription('Producten en diensten binnen burgerzaken');
    	$group->setCatalogue($eindhoven);
    	$manager->persist($group);    	
    	
    	$trouwproducten = new Group();
    	$trouwproducten->setSourceOrganization('002220647'); // Utrecht
    	$trouwproducten->setName('Trouwproducten');
    	$trouwproducten->setDescription('Producten en diensten binnen het trouw proces');
    	$trouwproducten->setCatalogue($utrecht);
    	$manager->persist($trouwproducten);
    	
    	$trouwAmbtenaren = new Group();
    	$trouwAmbtenaren->setSourceOrganization('002220647'); // Utrecht
    	$trouwAmbtenaren->setName('Trouw Ambtenaren');
    	$trouwAmbtenaren->setDescription('Door wie wilt u worden getrouwd?');
    	$trouwAmbtenaren->setCatalogue($utrecht);
    	$manager->persist($trouwAmbtenaren);
    	
    	$trouwLocaties  = new Group();
    	$trouwLocaties->setSourceOrganization('002220647'); // Utrecht
    	$trouwLocaties->setName('Trouw Locaties');
    	$trouwLocaties->setDescription('Waar wilt u trouwen?');
    	$trouwLocaties->setCatalogue($utrecht);
    	$manager->persist($trouwLocaties);
    	
    	// Producten
    	$trouwen = new Product();
    	$trouwen->setSourceOrganization('002220647');
    	$trouwen->setName('Trouwen / Partnerschap');
    	$trouwen->setDescription('Trouwen');
    	$trouwen->setType('set'); 
    	$trouwen->addGroup($trouwproducten);
    	$trouwen->setCatalogue($utrecht);
    	$trouwen->setPrice('627.00');
    	$trouwen->setPriceCurrency('EUR');
    	$trouwen->setTaxPercentage(0);
    	$manager->persist($trouwen);
    	
    	
    	$ceremonies = new Group();
    	$ceremonies->setRsin('002220647'); // Utrecht
    	$ceremonies->setName('Ceremonies ');
    	$ceremonies->setDescription('Verschillende cermonies voor uw huwelijk / partnerschap');
    	$ceremonies->setCatalogus($utrecht);
    	$manager->persist($ceremonies);
    	
    	$eenvoudigtrouwen = new Product();
    	$eenvoudigtrouwen->setSourceOrganization('002220647');
    	$eenvoudigtrouwen->setName('Eenvoudig trouwen');
    	$eenvoudigtrouwen->setDescription('Eenvoudig trouwen');
    	$eenvoudigtrouwen->setType('set'); 
    	$eenvoudigtrouwen->addGroup($trouwproducten);
    	$eenvoudigtrouwen->addGroup($ceremonies);
    	$eenvoudigtrouwen->setCatalogus($utrecht);
    	$eenvoudigtrouwen->setPrice('163.00');
    	$eenvoudigtrouwen->setPriceCurrency('EUR');
    	$eenvoudigtrouwen->setTaxPercentage('0');
    	$manager->persist($eenvoudigtrouwen);
    	
    	$gratistrouwen = new Product();
    	$gratistrouwen->setSourceOrganization('002220647');
    	$gratistrouwen->setName('Gratis Trouwen');
    	$gratistrouwen->setDescription('Gratis huwelijk');
    	$gratistrouwen->setType('set'); 
    	$gratistrouwen->addGroup($trouwproducten);
    	$gratistrouwen->addGroup($ceremonies);
    	$gratistrouwen->setCatalogus($utrecht);
    	$gratistrouwen->setPrice('0.00');
    	$gratistrouwen->setPriceCurrency('EUR');
    	$gratistrouwen->setTaxPercentage(0);
    	$manager->persist($gratistrouwen);
    	
    	$trouwambtenaar = new Product();
    	$trouwambtenaar->setSourceOrganization('002220647');
    	$trouwambtenaar->setName('Trouwambtenaar');
    	$trouwambtenaar->setDescription('<p>Een trouwambtenaar heet officieel een buitengewoon ambtenaar van de burgerlijke stand (babs ). Een babs waarmee het klikt is belangrijk. Hieronder stellen de babsen van de gemeente Utrecht zich aan u voor. U kunt een voorkeur aangeven voor een van hen, dan krijgt u data te zien waarop die babs beschikbaar is. Wanneer u een babs heeft gekozen zal deze na de melding voorgenomen huwelijk, zelf contact met u opnemen.</p>

<p>Kiest u liever voor een babs uit een andere gemeente? Of voor een vriend of familielid als trouwambtenaar? Dan kunt u hem of haar laten benoemen tot trouwambtenaar voor 1 dag bij de gemeente Utrecht. Dit kunt u hier ook opgeven.</p>

<p>Bij een gratis of een eenvoudig huwelijk of geregistreerd partnerschap kunt u niet zelf een babs kiezen, de gemeente wijst er een toe.</p>');
    	$trouwambtenaar->setType('variable'); 
    	$trouwambtenaar->addGroup($trouwproducten);
    	$trouwambtenaar->addGroup($ceremonies);
    	$trouwambtenaar->setCatalogus($utrecht);
    	$trouwambtenaar->setPrice('0.00');
    	$trouwambtenaar->setPriceCurrency('EUR');
    	$trouwambtenaar->setTaxPercentage(0);
    	$trouwambtenaar->addSet($trouwen);
    	$trouwambtenaar->addSet($eenvoudigtrouwen);
    	$trouwambtenaar->addSet($gratistrouwen);
    	$manager->persist($trouwambtenaar);
    	
    	$ambtenaar = new Product();
    	$ambtenaar->setSourceOrganization('123456789');
    	$ambtenaar->setLogo('https://utrecht.trouwplanner.online/images/content/ambtenaar/erik.jpg');
    	$ambtenaar->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$ambtenaar->setName('Dhr Erik Hendrik');
    	$ambtenaar->setDescription('<p>Als Buitengewoon Ambtenaar van de Burgerlijke Stand geef ik, in overleg met het bruidspaar, invulling aan de huwelijksceremonie.</p>');
    	$ambtenaar->setType('person');
    	$ambtenaar->addGroup($trouwproducten);
    	$ambtenaar->addGroup($trouwAmbtenaren);
    	$ambtenaar->setCatalogue($utrecht);
    	$ambtenaar->setPrice('0.00');
    	$ambtenaar->setPriceCurrency('EUR');
    	$ambtenaar->setTaxPercentage(0);
    	$ambtenaar->setParent($trouwambtenaar);
    	$manager->persist($ambtenaar);
    	
    	$ambtenaar = new Product();
    	$ambtenaar->setSourceOrganization('123456789');
    	$ambtenaar->setLogo('https://utrecht.trouwplanner.online/images/content/ambtenaar/ike.jpg');
    	$ambtenaar->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$ambtenaar->setName('Mvr Ike van den Pol');
    	$ambtenaar->setDescription('<p>Elkaar het Ja-woord geven, de officiële ceremonie. Vaak is dit het romantische hoogtepunt van de trouwdag. Een bijzonder moment, gedeeld met de mensen die je lief zijn. Een persoonlijke ceremonie, passend bij jullie relatie. Alles is bespreekbaar en maatwerk. Een originele trouwplechtigheid waar muziek, sprekers en kinderen een rol kunnen spelen. Een ceremonie met inhoud, ernst en humor, een traan en een lach, stijlvol, spontaan en ontspannen.</p>');
    	$ambtenaar->setType('person');
    	$ambtenaar->addGroup($trouwproducten);
    	$ambtenaar->addGroup($trouwAmbtenaren);
    	$ambtenaar->setCatalogue($utrecht);
    	$ambtenaar->setPrice('0.00');
    	$ambtenaar->setPriceCurrency('EUR');
    	$ambtenaar->setTaxPercentage(0);
    	$ambtenaar->setParent($trouwambtenaar);
    	$manager->persist($ambtenaar);
    	
    	$ambtenaar = new Product();
    	$ambtenaar->setSourceOrganization('123456789');
    	$ambtenaar->setLogo('https://utrecht.trouwplanner.online/images/content/ambtenaar/rene.jpg');
    	$ambtenaar->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$ambtenaar->setName('Dhr. Rene Gulje');
    	$ambtenaar->setDescription('<p>Ik ben Rene Gulje, in 1949 in Amsterdam geboren. Ik studeerde Nederlands aan de UVA en journalistiek aan de HU.</p>');
    	$ambtenaar->setType('person');
    	$ambtenaar->addGroup($trouwproducten);
    	$ambtenaar->addGroup($trouwAmbtenaren);
    	$ambtenaar->setCatalogue($utrecht);
    	$ambtenaar->setPrice('0.00');
    	$ambtenaar->setPriceCurrency('EUR');
    	$ambtenaar->setTaxPercentage(0);
    	$ambtenaar->setParent($trouwambtenaar);
    	$manager->persist($ambtenaar);
    	
    	$ambtenaar = new Product();
    	$ambtenaar->setSourceOrganization('123456789');
    	$ambtenaar->setLogo('https://utrecht.trouwplanner.online/images/content/elements/Trouwambtenaren.png');
    	$ambtenaar->setMovie('https://www.youtube.com/embed/RkBZYoMnx5w');
    	$ambtenaar->setName('Toegewezen Trouwamberbaar');
    	$ambtenaar->setDescription('Uw trouwambtenaar wordt toegewezen, over enkele dagen krijgt u bericht van uw toegewezen trouwambtenaar!');
    	$ambtenaar->setType('simple');
    	$ambtenaar->addGroup($trouwproducten);
    	$ambtenaar->addGroup($trouwAmbtenaren);
    	$ambtenaar->setCatalogue($utrecht);
    	$ambtenaar->setPrice('0.00');
    	$ambtenaar->setPriceCurrency('EUR');
    	$ambtenaar->setTaxPercentage(0);
    	$ambtenaar->setParent($trouwambtenaar);
    	$manager->persist($ambtenaar);
    	
    	$ambtenaar = new Product();
    	$ambtenaar->setSourceOrganization('123456789');
    	$ambtenaar->setLogo('https://utrecht.trouwplanner.online/images/content/elements/Trouwambtenaren.png');
    	$ambtenaar->setMovie('https://www.youtube.com/embed/RkBZYoMnx5w');
    	$ambtenaar->setName('Zelfgekozen BABS ');
    	$ambtenaar->setDescription('U draagt zelf een trouwambtenaar voor en laat deze voor een dag beëdigen');
    	$ambtenaar->setType('simple');
    	$ambtenaar->addGroup($trouwproducten);
    	$ambtenaar->addGroup($trouwAmbtenaren);
    	$ambtenaar->setCatalogue($utrecht);
    	$ambtenaar->setPrice('150.00');
    	$ambtenaar->setPriceCurrency('EUR');
    	$ambtenaar->setTaxPercentage(0);
    	$ambtenaar->setParent($trouwambtenaar);
    	$manager->persist($ambtenaar);
    	
    	
    	$locatie= new Product();
    	$locatie->setSourceOrganization('002220647');
    	$locatie->setName('Locatie');
    	$locatie->setDescription('<p>Een trouwlocatie; in Utrecht is er voor elk wat wils. De gemeente Utrecht heeft een aantal eigen trouwlocaties; het Stadhuis, het Wijkservicecentrum in Vleuten en het Stadskantoor. Een keuze voor een van deze trouwlocaties kunt u direct hier doen.</p>

<p>Daarnaast zijn er verschillende andere vaste trouwlocaties. Deze trouwlocaties zijn door de gemeente Utrecht al goedgekeurd. Hieronder vindt u het overzicht van deze trouwlocaties. Heeft u een keuze gemaakt uit een van de vaste trouwlocaties? Maak dan eerst een afspraak met de locatie en geef dan aan ons door waar en wanneer u wilt trouwen.</p>

<p>Maar misschien wilt u een heel andere locatie. Bijvoorbeeld het caf&eacute; om de hoek, bij u thuis of in uw favoriete restaurant. Zo\'n locatie heet een vrije locatie. Een aanvraag voor een vrije locatie kunt u hier ook doen.</p>');
    	$locatie->setType('variable');
    	$locatie->addGroup($trouwproducten);
    	$locatie->setCatalogue($utrecht);
    	$locatie->setPrice('0.00');
    	$locatie->setPriceCurrency('EUR');
    	$locatie->addSet($trouwen);
    	$locatie->addSet($eenvoudigtrouwen);
    	$locatie->addSet($gratistrouwen);
    	$locatie->setTaxPercentage('0');
    	$manager->persist($locatie);
    	
    	$product = new Product();
    	$product->setSourceOrganization('123456789');
    	$product->setLogo('https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/Trouwzaal-Stadskantoor-Utrecht.jpg');
    	$product->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$product->setName('Stadskantoor');
    	$product->setDescription('Deze locatie is speciaal voor eenvoudige en gratis huwelijken.
 De zaal ligt op de 6e etage van het Stadskantoor.
 De ruimte is eenvoudig en toch heel intiem.
 Het licht is in te stellen op een kleur die jullie graag willen.');
    	$product->setType('simple');
    	$product->addGroup($trouwproducten);
    	$product->addGroup($trouwLocaties);
    	$product->setCatalogue($utrecht);
    	$product->setPrice('0.00');
    	$product->setPriceCurrency('EUR');
    	$product->setTaxPercentage(0);
    	$product->setParent($locatie);
    	$manager->persist($product);
    	
    	$product = new Product();
    	$product->setSourceOrganization('123456789');
    	$product->setLogo('https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/kleine-trouwzaal-stadhuis-utrecht.jpg');
    	$product->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$product->setName('Stadhuis kleine zaal');
    	$product->setDescription('Deze uiterst sfeervolle trouwzaal maakt de dag compleet');
    	$product->setType('simple');
    	$product->addGroup($trouwproducten);
    	$product->addGroup($trouwLocaties);
    	$product->setCatalogue($utrecht);
    	$product->setPrice('0.00');
    	$product->setPriceCurrency('EUR');
    	$product->setTaxPercentage(0);
    	$product->setParent($locatie);
    	$manager->persist($product);
    	
    	$product = new Product();
    	$product->setSourceOrganization('123456789');
    	$product->setLogo('https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/grote-trouwzaal-stadhuis-utrecht.jpg');
    	$product->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$product->setName('Stadhuis grote zaal');
    	$product->setDescription('Deze uiterst sfeervolle trouwzaal is perfect voor ieder koppel');
    	$product->setType('simple');
    	$product->addGroup($trouwproducten);
    	$product->addGroup($trouwLocaties);
    	$product->setCatalogue($utrecht);
    	$product->setPrice('0.00');
    	$product->setPriceCurrency('EUR');
    	$product->setTaxPercentage(0);
    	$product->setParent($locatie);
    	$manager->persist($product);
    	
    	$product = new Product();
    	$product->setSourceOrganization('123456789');
    	$product->setLogo('https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/grote-trouwzaal-stadhuis-utrecht.jpg');
    	$product->setMovie('https://www.youtube.com/embed/DAaoMvj1Qbs');
    	$product->setName('Vrije locatie');
    	$product->setDescription('Vrije locatie');
    	$product->setType('simple');
    	$product->addGroup($trouwproducten);
    	$product->addGroup($trouwLocaties);
    	$product->setCatalogue($utrecht);
    	$product->setPrice('0.00');
    	$product->setPriceCurrency('EUR');
    	$product->setTaxPercentage(0);
    	$product->setParent($locatie);
    	$manager->persist($product);
    	
    	$trouwboekje = new Product();
    	$trouwboekje->setSourceOrganization('002220647');
    	$trouwboekje->setName('Trouwboekje'); 
    	$trouwboekje->setDescription('Een mooi in leer gebonden herindering aan uw huwelijk');
    	$trouwboekje->setType('variable');
    	$trouwboekje->addGroup($trouwproducten);
    	$trouwboekje->setCatalogue($utrecht);
    	$trouwboekje->setPrice('30.20');
    	$trouwboekje->setPriceCurrency('EUR');
    	$trouwboekje->setTaxPercentage('0');
        $manager->persist($trouwboekje);
        

        $manager->flush();
    }
}
