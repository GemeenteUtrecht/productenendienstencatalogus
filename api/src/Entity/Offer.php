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
 * An entity representing an offer
 *
 * This entity represents an offer that bridges products to the OrderRegistratieComponent to be able to change prices without invalidating past orders.
 *
 * @author Robert Zondervan <robert@conduction.nl>
 * @category Entity
 * @license EUPL <https://github.com/ConductionNL/productenendienstencatalogus/blob/master/LICENSE.md>
 * @package PDC
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
{
    /**
     * @var UuidInterface $id The UUID identifier of this object
     * @example e2984465-190a-4562-829e-a8cca81aa35d
     * @Assert\Uuid
     * @ApiProperty(
     * 	   identifier=true,
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The UUID identifier of this object",
     *             "type"="string",
     *             "format"="uuid",
     *             "example"="e2984465-190a-4562-829e-a8cca81aa35d"
     *         }
     *     }
     * )
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
     * @var Product $product The product that is sold via this offer
     *
     * @Assert\NotNull
     * @Assert\Valid
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     * @MaxDepth(1)
     * @Groups({"read"})
     */
    private $product;

    /**
     *  @var string $price The price of this product
     *  @example 50.00
     *
     *  @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "iri"="https://schema.org/price",
     *         	   "description" = "The price of this product",
     *             "type"="string",
     *             "example"="50.00",
     *             "maxLength"="9",
     *             "required" = true
     *         }
     *     }
     * )
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
     *  @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "iri"="https://schema.org/priceCurrency",
     *         	   "description" = "The currency of this product in an [ISO 4217](https://en.wikipedia.org/wiki/ISO_4217) format",
     *             "type"="string",
     *             "example"="EUR",
     *             "default"="EUR",
     *             "maxLength"="3",
     *             "minLength"="3"
     *         }
     *     }
     * )
     *
     * @Assert\Currency
     * @Groups({"read","write"})
     * @ORM\Column(type="string")
     */
    private $priceCurrency = 'EUR';

    /**
     * @var string $offeredBy The uri for the organisation that offers this offer
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     * @Assert\Url
     * @Assert\Length(
     *     max = 255
     * )
     * @Groups({"read","write"})
     */
    private $offeredBy;

    /**
     * @var DateTime $availabilityEnds the date this offer ends
     * @ORM\Column(type="datetime")
     * @Assert\NotNull
     * @Assert\Date
     *
     * @Groups({"read","write"})
     */
    private $availabilityEnds;

    /**
     * @var DateTime $availabilityStarts the date this offer has started
     * @Assert\NotNull
     * @Assert\Date
     * @ORM\Column(type="datetime")
     * @Groups({"read","write"})
     */
    private $availabilityStarts;

    /**
     *  @var integer $taxPercentage The tax percentage for this offer as an integer e.g. 9% makes 9
     *  @example 9
     *
     *  @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The tax percentage for this offer as an integer e.g. 9% makes 9",
     *             "type"="integer",
     *             "example"="9",
     *             "maxLength"="3",
     *             "minLength"="1",
     *             "required" = true
     *         }
     *     }
     * )
     *
     * @Assert\NotBlank
     * @Assert\PositiveOrZero
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer")
     */
    private $taxPercentage;

    /**
     * @var ArrayCollection $eligibleCustomerTypes The customer types that are eligible for this offer
     * @ORM\ManyToMany(targetEntity="App\Entity\CustomerType", mappedBy="offers")
     * @MaxDepth(1)
     * @Groups({"read","write"})
     */
    private $eligibleCustomerTypes;

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

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): self
    {
        $this->product = $product;

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

    public function getOfferedBy(): ?string
    {
        return $this->offeredBy;
    }

    public function setOfferedBy(string $offeredBy): self
    {
        $this->offeredBy = $offeredBy;

        return $this;
    }

    public function getAvailabilityEnds(): ?\DateTimeInterface
    {
        return $this->availabilityEnds;
    }

    public function setAvailabilityEnds(\DateTimeInterface $availabilityEnds): self
    {
        $this->availabilityEnds = $availabilityEnds;

        return $this;
    }

    public function getAvailabilityStarts(): ?\DateTimeInterface
    {
        return $this->availabilityStarts;
    }

    public function setAvailabilityStarts(\DateTimeInterface $availabilityStarts): self
    {
        $this->availabilityStarts = $availabilityStarts;

        return $this;
    }

    public function getTaxPercentage(): ?int
    {
        return $this->taxPercentage;
    }

    public function setTaxPercentage(int $taxPercentage): self
    {
        $this->taxPercentage = $taxPercentage;

        return $this;
    }

    /**
     * @return Collection|CustomerType[]
     */
    public function getEligibleCustomerTypes(): Collection
    {
        return $this->eligibleCustomerTypes;
    }

    public function addEligibleCustomerType(CustomerType $eligibleCustomerType): self
    {
        if (!$this->eligibleCustomerTypes->contains($eligibleCustomerType)) {
            $this->eligibleCustomerTypes[] = $eligibleCustomerType;
            $eligibleCustomerType->addOffer($this);
        }

        return $this;
    }

    public function removeEligibleCustomerType(CustomerType $eligibleCustomerType): self
    {
        if ($this->eligibleCustomerTypes->contains($eligibleCustomerType)) {
            $this->eligibleCustomerTypes->removeElement($eligibleCustomerType);
            $eligibleCustomerType->removeOffer($this);
        }

        return $this;
    }
}
