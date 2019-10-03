<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Money\Currency;
use Money\Money;

use App\Entity\Service;
use App\Entity\Product;
use App\Entity\Supplier;
use App\Entity\Group;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	
    	$supplier= new Supplier();
    	$supplier->setKvk('27348329');
    	$supplier->setLogo('logo.png');
    	$manager->persist($supplier);
    	
    	$group = new Group();
    	$group->setOrganisation('123456789');
    	$group->setName('Trouwproducten');
    	$group->setDescription('Producten en diensten rondom het trouw proces');
    	$manager->persist($group);
    	
    	$product = new Product();
    	$product->setOrganisation('123456789');
    	$product->setName('Trouwboekje');
    	$product->setDescription('Een mooi in leer gebonden herindering aan uw huwelijk');
    	$product->addGroup($group);
    	$product->setPrice(Money::EUR(1500));
        $manager->persist($product);
        
        $service = new Service();
        $service->setOrganisation('123456789');
        $service->setName('Huwelijksvoltreking');
        $service->setDescription('Het voltrekken van een huwelijk');
        $service->addGroup($group);
        $service->setPrice(Money::EUR(17500));
        $manager->persist($service);

        $manager->flush();
    }
}
