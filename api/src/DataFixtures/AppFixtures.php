<?php

namespace App\DataFixtures;

use Ramsey\Uuid\Uuid;

use App\Entity\Catalogue;
use App\Entity\Group;
use App\Entity\Product;
use App\Entity\Supplier;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private function loadSupplier(
        string $name,
        string $sourceOrganisation,
        string $kvk,
        ?string $logo,
        ObjectManager $manager
    ):Supplier {
        $supplier = new Supplier();
        $supplier->setName($name);
        $supplier->setSourceOrganization($sourceOrganisation);
        $supplier->setKvk($kvk);
        if ($logo) {
            $supplier->setLogo($logo);
        }
        $manager->persist($supplier);

        return $supplier;
    }

    private function loadCatalogue(
        string $name,
        string $sourceOrganisation,
        ?string $description,
        ?string $logo,
        ObjectManager $manager
    ):Catalogue {
        $catalogue = new Catalogue();
        $catalogue->setName($name);
        $catalogue->setSourceOrganization($sourceOrganisation);
        if ($description) {
            $catalogue->setDescription($description);
        }
        if ($logo) {
            $catalogue->setLogo($logo);
        }
        $manager->persist($catalogue);

        return $catalogue;
    }

    private function loadGroup(
        string $name,
        string $sourceOrganisation,
        Catalogue $catalogue,
        ?string $description,
        ?string $logo,
        ObjectManager $manager
    ):Group {
        $group = new Group();
        $group->setName($name);
        $group->setSourceOrganization($sourceOrganisation);
        $group->setCatalogue($catalogue);
        if ($description) {
            $group->setDescription($description);
        }
        if ($logo) {
            $group->setLogo($logo);
        }
        $manager->persist($group);

        return $group;
    }

    private function loadProduct(
        string $name,
        string $sourceOrganisation,
        ?string $description,
        string $type,
        ?array $groups,
        ?array $sets,
        Catalogue $catalogue,
        string $price,
        string $currency,
        int $taxPercentage,
        bool $requiresAppointment,
        ?string $logo,
        ?string $movie,
        ?Product $parent,
        ObjectManager $manager
    ):Product {
        $product = new Product();
        $product->setName($name);
        $product->setSourceOrganization($sourceOrganisation);
        if ($description) {
            $product->setDescription($description);
        }
        $product->setType($type);
        if ($groups) {
            foreach ($groups as $group) {
                $product->addGroup($group);
            }
        }
        if ($sets) {
            foreach ($sets as $set) {
                $product->addSet($set);
            }
        }
        $product->setCatalogue($catalogue);
        $product->setPrice($price);
        $product->setPriceCurrency($currency);
        $product->setTaxPercentage($taxPercentage);
        $product->setRequiresAppointment($requiresAppointment);
        if ($logo) {
            $product->setLogo($logo);
        }
        if ($movie) {
            $product->setMovie($movie);
        }
        if ($parent) {
            $product->setParent($parent);
        }

        $manager->persist($product);

        return $product;
    }

    public function load(ObjectManager $manager)
    {
        // Eerst een de suppliers aanmaken
        $this->loadSupplier('Gemeente \'s-Hertogenbosch', '001709124', '17278704', null, $manager);
        $this->loadSupplier('Gemeente Eindhoven', '001902763', '17272738', null, $manager);
        $this->loadSupplier('Gemeente Utrecht', '002220647', '30280353', null, $manager);

        // Catalogi
        $vng = $this->loadCatalogue('Vereniging Nederlandse Gemeenten', '0000', null, null, $manager);
        $denbosch = $this->loadCatalogue('Gemeente \'s-Hertogenbosch', '001709124', null, null, $manager);
        $eindhoven = $this->loadCatalogue('Gemeente Eindhoven', '001902763', null, null, $manager);
        $utrecht = $this->loadCatalogue('Gemeente Utrecht', '002220647', null, null, $manager);

        // Dan wat productgroepen        
        // $id = Uuid::fromString('9d76fb58-0711-4437-acc4-9f4d9d403cdf');
        $burgerzakenDenBosh = new Group();
        $burgerzakenDenBosh->setName('Burgerzaken');
        $burgerzakenDenBosh->setDescription('Alle producten met betrekking tot burgerzaken');
        $burgerzakenDenBosh->setSourceOrganization('001709124');
        $burgerzakenDenBosh->setCatalogue($denbosch);
        $manager->persist($burgerzakenDenBosh);
        //$burgerzakenDenBosh->setId($id);
        //$manager->persist($burgerzakenDenBosh);
        $manager->flush();
        
        // $id = Uuid::fromString('9d76fb58-0711-4437-acc4-9f4d9d403cdf');
        $burgerzakeEindhoven = new Group();
        $burgerzakeEindhoven->setName('Burgerzaken');
        $burgerzakeEindhoven->setDescription('Alle producten met betrekking tot burgerzaken');
        $burgerzakeEindhoven->setSourceOrganization('002220647');
        $burgerzakeEindhoven->setCatalogue($eindhoven);
        $manager->persist($burgerzakeEindhoven);
        //$burgerzakeEindhoven->setId($id);
        //$manager->persist($burgerzakeEindhoven);
        $manager->flush();
        
        // $id = Uuid::fromString('9d76fb58-0711-4437-acc4-9f4d9d403cdf');
        $burgerzakenUtrecht = new Group();
        $burgerzakenUtrecht->setName('Burgerzaken');
        $burgerzakenUtrecht->setDescription('Alle producten met betrekking tot burgerzaken');
        $burgerzakenUtrecht->setSourceOrganization('002220647');
        $burgerzakenUtrecht->setCatalogue($utrecht);
        $manager->persist($burgerzakenUtrecht);
        //$burgerzakenUtrecht->setId($id);
        //$manager->persist($burgerzakenUtrecht);
        $manager->flush();
        
        
        // $id = Uuid::fromString('9d76fb58-0711-4437-acc4-9f4d9d403cdf');
        $trouwenUtrecht = new Group();
        $trouwenUtrecht->setName('Trouwproducten');
        $trouwenUtrecht->setDescription('Alle producten met betrekking tot burgerzaken');
        $trouwenUtrecht->setSourceOrganization('002220647');
        $trouwenUtrecht->setCatalogue($utrecht);
        $manager->persist($trouwenUtrecht);
        //$trouwenUtrecht->setId($id);
        //$manager->persist($trouwenUtrecht);
        $manager->flush();
        
        
        $id = Uuid::fromString('7f4ff7ae-ed1b-45c9-9a73-3ed06a36b9cc');
        $trouwenAmbtenarenUtrecht= new Group();
        $trouwenAmbtenarenUtrecht->setName('Trouwambtenaren');
        $trouwenAmbtenarenUtrecht->setDescription('Door wie wilt u worden getrouwd?');
        $trouwenAmbtenarenUtrecht->setSourceOrganization('002220647');
        $trouwenAmbtenarenUtrecht->setCatalogue($utrecht);
        $manager->persist($trouwenAmbtenarenUtrecht);
        $trouwenAmbtenarenUtrecht->setId($id);
        $manager->persist($trouwenAmbtenarenUtrecht);
        $manager->flush();
        
        
        $id = Uuid::fromString('170788e7-b238-4c28-8efc-97bdada02c2e');
        $trouwenLocatiesUtrecht= new Group();
        $trouwenLocatiesUtrecht->setName('Trouwlocaties');
        $trouwenLocatiesUtrecht->setDescription('Waar wilt u trouwen?');
        $trouwenLocatiesUtrecht->setSourceOrganization('002220647');
        $trouwenLocatiesUtrecht->setCatalogue($utrecht);
        $manager->persist($trouwenLocatiesUtrecht);
        $trouwenLocatiesUtrecht->setId($id);
        $manager->persist($trouwenLocatiesUtrecht);
        $manager->flush();
        
        // $id = Uuid::fromString('9d76fb58-0711-4437-acc4-9f4d9d403cdf');
        $trouwenCeremoniersUtrecht= new Group();
        $trouwenCeremoniersUtrecht->setName('Ceremonies');
        $trouwenCeremoniersUtrecht->setDescription('Verschillende ceremonies voor uw huwelijk / partnerschap');
        $trouwenCeremoniersUtrecht->setSourceOrganization('002220647');
        $trouwenCeremoniersUtrecht->setCatalogue($utrecht);
        $manager->persist($trouwenCeremoniersUtrecht);
        //$trouwenCeremoniersUtrecht->setId($id);
        //$manager->persist($trouwenCeremoniersUtrecht);
        

        // Producten
        $trouwen = $this->loadProduct(
            'Trouwen / Partnerschap',
            '002220647',
            'Trouwen',
            'set',
        		[$trouwenUtrecht],
            null,
            $utrecht,
            '627.00',
            'EUR',
            0,
            false,
            null,
            null,
            null,
            $manager
        );
        
        $eenvoudigtrouwen = $this->loadProduct(
            'Eenvoudig Trouwen',
            '002220647',
            'Eenvoudig Trouwen',
            'set',
            [$trouwenUtrecht],
            null,
            $utrecht,
            '163.00',
            'EUR',
            0,
            false,
            null,
            null,
            null,
            $manager
        );
        
        $gratistrouwen = $this->loadProduct(
            'Gratis Trouwen',
            '002220647',
            'Gratis huwelijk',
            'set',
            [$trouwenUtrecht],
            null,
            $utrecht,
            '0.00',
            'EUR',
            0,
            false,
            null,
            null,
            null,
            $manager
        );
        
        $trouwambtenaar = $this->loadProduct(
            'Trouwambtenaar',
            '002220647',
            '<p>Een trouwambtenaar heet officieel een buitengewoon ambtenaar van de burgerlijke stand (babs ). Een babs waarmee het klikt is belangrijk. Hieronder stellen de babsen van de gemeente Utrecht zich aan u voor. U kunt een voorkeur aangeven voor een van hen, dan krijgt u data te zien waarop die babs beschikbaar is. Wanneer u een babs heeft gekozen zal deze na de melding voorgenomen huwelijk, zelf contact met u opnemen.</p>
    
    <p>Kiest u liever voor een babs uit een andere gemeente? Of voor een vriend of familielid als trouwambtenaar? Dan kunt u hem of haar laten benoemen tot trouwambtenaar voor 1 dag bij de gemeente Utrecht. Dit kunt u hier ook opgeven.</p>
    
    <p>Bij een gratis of een eenvoudig huwelijk of geregistreerd partnerschap kunt u niet zelf een babs kiezen, de gemeente wijst er een toe.</p>',
            'variable',
        	[$trouwenUtrecht, $trouwenCeremoniersUtrecht],
            [$trouwen, $eenvoudigtrouwen, $gratistrouwen],
            $utrecht,
            '0.00',
            'EUR',
            0,
            true,
            null,
            null,
            null,
            $manager
        );
        
        $this->loadProduct(
            'Dhr Erik Hendrik',
            '123456789',
            '<p>Als Buitengewoon Ambtenaar van de Burgerlijke Stand geef ik, in overleg met het bruidspaar, invulling aan de huwelijksceremonie.</p>',
            'person',
        		[$trouwenUtrecht, $trouwenAmbtenarenUtrecht],
            null,
            $utrecht,
            '0.00',
            'EUR',
            0,
            true,
            'https://utrecht.trouwplanner.online/images/content/ambtenaar/erik.jpg',
            'https://www.youtube.com/embed/DAaoMvj1Qbs',
            $trouwambtenaar,
            $manager
        );
        
        $this->loadProduct(
            'Dhr Erik Hendrik',
            '123456789',
            '<p>Als Buitengewoon Ambtenaar van de Burgerlijke Stand geef ik, in overleg met het bruidspaar, invulling aan de huwelijksceremonie.</p>',
            'person',
        		[$trouwenUtrecht, $trouwenAmbtenarenUtrecht],
            null,
            $utrecht,
            '0.00',
            'EUR',
            0,
            true,
            'https://utrecht.trouwplanner.online/images/content/ambtenaar/erik.jpg',
            'https://www.youtube.com/embed/DAaoMvj1Qbs',
            $trouwambtenaar,
            $manager
        );
        
        $this->loadProduct(
            'Mvr Ike van den Pol',
            '123456789',
            '<p>Elkaar het Ja-woord geven, de officiële ceremonie. Vaak is dit het romantische hoogtepunt van de trouwdag. Een bijzonder moment, gedeeld met de mensen die je lief zijn. Een persoonlijke ceremonie, passend bij jullie relatie. Alles is bespreekbaar en maatwerk. Een originele trouwplechtigheid waar muziek, sprekers en kinderen een rol kunnen spelen. Een ceremonie met inhoud, ernst en humor, een traan en een lach, stijlvol, spontaan en ontspannen.</p>',
            'person',
        		[$trouwenUtrecht, $trouwenAmbtenarenUtrecht],
            null,
            $utrecht,
            '0.00',
            'EUR',
            0,
            true,
            'https://utrecht.trouwplanner.online/images/content/ambtenaar/ike.jpg',
            'https://www.youtube.com/embed/DAaoMvj1Qbs',
            $trouwambtenaar,
            $manager
        );
        
        $this->loadProduct(
            'Dhr. Rene Gulje',
            '123456789',
            '<p>Ik ben Rene Gulje, in 1949 in Amsterdam geboren. Ik studeerde Nederlands aan de UVA en journalistiek aan de HU.</p>',
            'person',
        		[$trouwenUtrecht, $trouwenAmbtenarenUtrecht],
            null,
            $utrecht,
            '0.00',
            'EUR',
            0,
            true,
            'https://utrecht.trouwplanner.online/images/content/ambtenaar/rene.jpg',
            'https://www.youtube.com/embed/DAaoMvj1Qbs',
            $trouwambtenaar,
            $manager
        );
        
        $ambtenaar = $this->loadProduct(
            'Toegewezen Trouwamberbaar',
            '123456789',
            'Uw trouwambtenaar wordt toegewezen, over enkele dagen krijgt u bericht van uw toegewezen trouwambtenaar!',
            'simple',
        		[$trouwenUtrecht, $trouwenAmbtenarenUtrecht],
            null,
            $utrecht,
            '0.00',
            'EUR',
            0,
            true,
            'https://utrecht.trouwplanner.online/images/content/elements/Trouwambtenaren.png',
            'https://www.youtube.com/embed/RkBZYoMnx5w',
            $trouwambtenaar,
            $manager
        );
        $ambtenaar = $this->loadProduct(
            'Zelfgekozen BABS',
            '123456789',
            'U draagt zelf een trouwambtenaar voor en laat deze voor een dag beëdigen',
            'simple',
        		[$trouwenUtrecht, $trouwenAmbtenarenUtrecht],
            null,
            $utrecht,
            '150.00',
            'EUR',
            0,
            true,
            'https://utrecht.trouwplanner.online/images/content/elements/Trouwambtenaren.png',
            'https://www.youtube.com/embed/RkBZYoMnx5w',
            $trouwambtenaar,
            $manager
        );
        
        $locatie = $this->loadProduct(
            'Locatie',
            '002220647',
            '<p>Een trouwlocatie; in Utrecht is er voor elk wat wils. De gemeente Utrecht heeft een aantal eigen trouwlocaties; het Stadhuis, het Wijkservicecentrum in Vleuten en het Stadskantoor. Een keuze voor een van deze trouwlocaties kunt u direct hier doen.</p>

<p>Daarnaast zijn er verschillende andere vaste trouwlocaties. Deze trouwlocaties zijn door de gemeente Utrecht al goedgekeurd. Hieronder vindt u het overzicht van deze trouwlocaties. Heeft u een keuze gemaakt uit een van de vaste trouwlocaties? Maak dan eerst een afspraak met de locatie en geef dan aan ons door waar en wanneer u wilt trouwen.</p>

<p>Maar misschien wilt u een heel andere locatie. Bijvoorbeeld het caf&eacute; om de hoek, bij u thuis of in uw favoriete restaurant. Zo\'n locatie heet een vrije locatie. Een aanvraag voor een vrije locatie kunt u hier ook doen.</p>',
            'variable',
        	[$trouwenUtrecht],
            [$trouwen, $eenvoudigtrouwen, $gratistrouwen],
            $utrecht,
            '0.00',
            'EUR',
            0,
            true,
            null,
            null,
            null,
            $manager
        );
        
        $this->loadProduct(
            'Stadskantoor',
            '123456789',
            'Deze locatie is speciaal voor eenvoudige en gratis huwelijken.
 De zaal ligt op de 6e etage van het Stadskantoor.
 De ruimte is eenvoudig en toch heel intiem.
 Het licht is in te stellen op een kleur die jullie graag willen.',
            'simple',
        		[$trouwenUtrecht, $trouwenLocatiesUtrecht],
            null,
            $utrecht,
            '0.00',
            'EUR',
            0,
            true,
            'https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/Trouwzaal-Stadskantoor-Utrecht.jpg',
            'https://www.youtube.com/embed/DAaoMvj1Qbs',
            $locatie,
            $manager
        );
        
        $this->loadProduct(
            'Stadhuis kleine zaal',
            '123456789',
            'Deze uiterst sfeervolle trouwzaal maakt de dag compleet',
            'simple',
        		[$trouwenUtrecht, $trouwenLocatiesUtrecht],
            null,
            $utrecht,
            '0.00',
            'EUR',
            0,
            true,
            'https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/kleine-trouwzaal-stadhuis-utrecht.jpg',
            'https://www.youtube.com/embed/DAaoMvj1Qbs',
            $locatie,
            $manager
        );
        
        $this->loadProduct(
            'Stadhuis grote zaal',
            '123456789',
            'Deze uiterst sfeervolle trouwzaal maakt de dag compleet',
            'simple',
        		[$trouwenUtrecht, $trouwenLocatiesUtrecht],
            null,
            $utrecht,
            '0.00',
            'EUR',
            0,
            true,
            'https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/grote-trouwzaal-stadhuis-utrecht.jpg',
            'https://www.youtube.com/embed/DAaoMvj1Qbs',
            $locatie,
            $manager
        );
        
        $this->loadProduct(
            'Vrije locatie',
            '123456789',
            'Vrije locatie',
            'simple',
        		[$trouwenUtrecht, $trouwenLocatiesUtrecht],
            null,
            $utrecht,
            '0.00',
            'EUR',
            0,
            true,
            null,
            'https://www.youtube.com/embed/DAaoMvj1Qbs',
            $locatie,
            $manager
        );
        
        $this->loadProduct(
            'Trouwboekje',
            '002220647',
            'Een mooi in leer gebonden herindering aan uw huwelijk',
            'variable',
        		[$trouwenUtrecht],
            null,
            $utrecht,
            '30.20',
            'EUR',
            0,
            false,
            null,
            null,
            null,
            $manager
        );

        $manager->flush();
    }
}
