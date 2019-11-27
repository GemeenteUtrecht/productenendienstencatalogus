<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * An entity representing an tax
 *
 * This entity represents an offer that bridges products to the OrderRegistratieComponent to be able to change prices without invalidating past orders.
 *
 * @author Ruben van der Linde <ruben@conduction.nl>
 * @category Entity
 * @license EUPL <https://github.com/ConductionNL/productenendienstencatalogus/blob/master/LICENSE.md>
 * @package PDC
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TaxRepository")
 */
class Tax
{
    /**
     * @var UuidInterface $id The UUID identifier of this object
     * @example e2984465-190a-4562-829e-a8cca81aa35d
     *
     * @Assert\Uuid
     * @Groups({"read"})
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @var string $name The name of this offer
     * @example my offer
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     * @Assert\Length(
     *     max = 255
     * )
     * @Groups({"read","write"})
     */
    private $name;
    
    /**
     * @var string $description An short description of this Product
     * @example This is the best product ever
     *
     * @Assert\Length(
     *      max = 2550
     * )
     * @Groups({"read","write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string $price The price of this tax
     * @example 50.00
     *
     * @Groups({"read","write"})
     * @Assert\NotNull
     * @Groups({"read","write"})
     * @ORM\Column(type="decimal", precision=8, scale=2)
     */
    private $price;

    /**
     *  @var string $priceCurrency The currency of this product in an [ISO 4217](https://en.wikipedia.org/wiki/ISO_4217) format
     *  @example EUR
     *
     * @Assert\Currency
     * @Groups({"read","write"})
     * @ORM\Column(type="string")
     */
    private $priceCurrency = 'EUR';

    /**
     *  @var integer $percentage The tax percentage for this offer as an integer e.g. 9% makes 9
     *  @example 9
     *
     * @Assert\NotBlank
     * @Assert\PositiveOrZero
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer")
     */
    private $percentage;
    
    /**
     * @var ArrayCollection $offers The offers that use this tax
     *
     * @MaxDepth(1)
     * @Groups({"read","write"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Offer", inversedBy="taxes")
     */
    private $offers;

    public function __construct()
    {
        $this->eligibleCustomerTypes = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    public function getDescription(): ?string
    {
    	return $this->description;
    }
    
    public function setDescription(?string $description): self
    {
    	$this->description = $description;
    	
    	return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceCurrency(): ?string
    {
        return $this->priceCurrency;
    }

    public function setPriceCurrency(string $priceCurrency): self
    {
        $this->priceCurrency = $priceCurrency;

        return $this;
    }

    public function getPercentage(): ?int
    {
        return $this->percentage;
    }

    public function setPercentage(int $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }
    
    /**
     * @return Collection|Offer[]
     */
    public function getOffers(): Collection
    {
    	return $this->products;
    }
    
    public function addOffer(Offer $offer): self
    {
    	if (!$this->offers->contains($offer)) {
    		$this->offers[] = $offer;
    	}
    	
    	return $this;
    }
    
    public function removeOffer(Offer $product): self
    {
    	if ($this->offers->contains($offer)) {
    		$this->offers->removeElement($offer);
    	}
    	
    	return $this;
    }

}
