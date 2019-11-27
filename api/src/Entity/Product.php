<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * An entity representing a product.
 *
 * This entity represents a product that can be ordered via the OrderRegistratieComponent.
 *
 * @author Robert Zondervan <robert@conduction.nl>
 *
 * @category Entity
 *
 * @license EUPL <https://github.com/ConductionNL/productenendienstencatalogus/blob/master/LICENSE.md>
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ApiFilter(SearchFilter::class, properties={"groups.id": "exact"})
 * @ApiFilter(SearchFilter::class, properties={"sourceOgranization.id": "exact"})
 */
class Product
{
    /**
     * @var UuidInterface The UUID identifier of this object
     *
     * @example e2984465-190a-4562-829e-a8cca81aa35d
     *
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
     * @var string The human readable reference for this product, also known as Stock Keeping Unit (SKU)
     *
     * @example 6666-2019
     *
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The human readable reference for this product, also known as Stock Keeping Unit (SKU)",
     *             "type"="string",
     *             "example"="6666-2019",
     *             "maxLength"="255"
     *         }
     *     }
     * )
     *
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255, nullable=true) //, unique=true
     * @ApiFilter(SearchFilter::class, strategy="exact")
     */
    private $sku;

    /**
     * @var string The auto-incrementing id part of the reference, unique on a organization-year-id basis
     *
     * @example 000000000001
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    private $skuId;

    /**
     * @var string The name of this Product
     *
     * @example My product
     *
     * @ApiProperty(
     * 	   iri="http://schema.org/name",
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The name of this Product",
     *             "type"="string",
     *             "example"="My product",
     *             "maxLength"="255",
     *             "required" = true
     *         },
     *         "openapi_context"={
     *              "example"="My product"
     *          }
     *     }
     * )
     *
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string An short description of this Product
     *
     * @example This is the best product ever
     *
     * @ApiProperty(
     * 	   iri="https://schema.org/description",
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "An short description of this Product",
     *             "type"="string",
     *             "example"="This is the best product ever",
     *             "maxLength"="2550"
     *         },
     *         "openapi_context"={
     *              "example"="This is the best product ever"
     *          }
     *     }
     * )
     *
     * @Assert\Length(
     *      max = 2550
     * )
     * @Groups({"read","write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string The logo of this product
     *
     * @example https://www.my-organization.com/logo.png
     *
     * @ApiProperty(
     * 	   iri="https://schema.org/logo",
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The logo of this product",
     *             "type"="string",
     *             "format"="url",
     *             "example"="https://www.my-organization.com/logo.png",
     *             "maxLength"=255
     *         },
     *         "openapi_context"={
     *              "example"="https://www.my-organization.com/logo.png"
     *          }
     *     }
     * )
     *
     * @Assert\Url
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @var string The movie for this product
     *
     * @example https://www.youtube.com/embed/RkBZYoMnx5w
     *
     * @ApiProperty(
     * 	   iri="https://schema.org/logo",
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The movie for this product",
     *             "type"="string",
     *             "format"="url",
     *             "example"="https://www.youtube.com/embed/RkBZYoMnx5w",
     *             "maxLength"=255
     *         },
     *         "openapi_context"={
     *              "example"="https://www.youtube.com/embed/RkBZYoMnx5w"
     *          }
     *     }
     * )
     *
     * @Assert\Url
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $movie;

    /**
     * @var string The RSIN of the organization that owns this product
     *
     * @example 002851234
     *
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The RSIN of the organization that owns this product",
     *             "type"="string",
     *             "example"="002851234",
     *              "maxLength"="255",
     *             "required" = true
     *         },
     *         "openapi_context"={
     *              "example"="002851234"
     *          }
     *     }
     * )
     *
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 8,
     *      max = 11
     * )
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     * @ApiFilter(SearchFilter::class, strategy="exact")
     */
    private $sourceOrganization;

    /**
     * @var ArrayCollection The product groups that this product is a part of
     *
     *
     * @MaxDepth(1)
     * @Groups({"read", "write"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", mappedBy="products")
     */
    private $groups;

    /**
     *  @var string The price of this product
     *
     *  @ORM\Column(type="decimal", precision=8, scale=2)
     *
     *  @example 50.00
     *  @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "iri"="https://schema.org/price",
     *         	   "description" = "The price of this product",
     *             "type"="string",
     *             "example"="50.00",
     *             "maxLength"="9",
     *             "required" = true
     *         },
     *         "openapi_context"={
     *              "example"="50.00"
     *          }
     *     }
     * )
     *
     * @Assert\NotNull
     * @Groups({"read","write"})
     */
    private $price;

    /**
     *  @var string The currency of this product in an [ISO 4217](https://en.wikipedia.org/wiki/ISO_4217) format
     *
     * @ORM\Column(type="string")
     *
     * @example EUR
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
     *         },
     *         "openapi_context"={
     *              "example"="EUR"
     *          }
     *     }
     * )
     *
     * @Assert\Currency
     * @Groups({"read","write"})
     */
    private $priceCurrency = 'EUR';

    /**
     *  @var int The tax percentage for this product as an integer e.g. 9% makes 9
     *
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The tax percentage for this product as an integer e.g. 9% makes 9",
     *             "type"="integer",
     *             "example"="9",
     *             "maxLength"="3",
     *             "minLength"="1",
     *             "required" = true
     *         },
     *         "openapi_context"={
     *              "example"=9
     *          }
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
     * @var Product The product that this product is a variation of
     *
     * @MaxDepth(1)
     * @Groups({"write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="variations")
     */
    private $parent;

    /**
     * @var ArrayCollection The different variations that are available of this product
     *
     * @MaxDepth(1)
     * @Groups({"read"})
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="parent")
     */
    private $variations;

    /**
     * @var string The type of this product. **simple**: ,**set**: ,**virtual**: ,**external**: ,**ticket**: ,**variable**: ,**subscription**,**person**,**location**,**service**
     *
     * @example simple
     *
     * @ORM\Column
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *             "type"="string",
     *         	  "description" = "The type of this product. **simple**: ,**set**: ,**virtual**: ,**external**: ,**ticket**: ,**variable**: ,**subscription**,**person**,**location**,**service**",
     *             "enum"={"simple", "set", "virtual","external","ticket","variable","subscription","person","location","service"},
     *             "example"="simple",
     *             "required"="true"
     *         }
     *     }
     * )
     * @Assert\NotBlank
     * @Assert\Choice(
     *     choices = { "simple", "set", "virtual","external","ticket","variable","subscription","person","location","service" },
     *     message = "Choose either simple, set, virtual, external, ticket, variable, subscription, person, location or service, got {{ value }}"
     * )
     * @ApiFilter(SearchFilter::class, strategy="exact")
     * @ApiFilter(OrderFilter::class)
     * @Groups({"read", "write"})
     */
    private $type;

    /**
     * @var ArrayCollection If the product type is a **set** this contains the products that are part of that set
     *
     * @MaxDepth(1)
     * @Groups({"read"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", inversedBy="sets")
     */
    private $groupedProducts;

    /**
     * @var ArrayCollection The sets thats this product is a part of
     *
     * @MaxDepth(1)
     * @Groups({"write"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="groupedProducts")
     */
    private $sets;

    /**
     * @var Catalogue The Catalogue that this product belongs to
     *
     * @MaxDepth(1)
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogue", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     * @Groups({"read","write"})
     */
    private $catalogue;

    /**
     * @var ArrayCollection The offers that refer to this product
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Offer", mappedBy="product", orphanRemoval=true, cascade="persist")
     * @Assert\Valid
     *
     * @MaxDepth(1)
     * @Groups({"read", "write"})
     */
    private $offers;

    /**
     * @var string The uri referring to the calendar of this product.
     *
     * @example http://example.org/calendar/calendar
     * @ApiProperty(
     *     attributes={
     *          "openapi_context"={
     *              "example"="http://example.org/calendar/calendar"
     *          }
     *     }
     * )
     * @Assert\Url
     * @Assert\Length(
     *     max = 255
     * )
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $calendar;

    /**
     * @var bool If the product requires a physical appointment, for example to request travel documents or for the booking of hotel rooms
     *
     * @example false
     * @ApiProperty(
     *     attributes={
     *          "openapi_context"={
     *              "example"= false
     *          }
     *     }
     * )
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     * @Groups({"read", "write"})
     */
    private $requiresAppointment;

    /**
     * @var array An array of URLs pointing to documents related to this product
     *
     * @ORM\Column(type="simple_array", nullable=true)
     * @Groups({"read"})
     */
    private $documents = [];

    /**
     * @var array An array of URLs pointing to images related to this product
     *
     * @ORM\Column(type="simple_array", nullable=true)
     * @Groups({"read"})
     */
    private $images = [];

    /**
     * @var array An array of URLs pointing to external documents referred to from this product
     *
     * @ORM\Column(type="simple_array", nullable=true)
     * @Groups({"read"})
     */
    private $externalDocs = [];

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->variations = new ArrayCollection();
        $this->groupedProducts = new ArrayCollection();
        $this->sets = new ArrayCollection();
        $this->offers = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getSkuId(): ?int
    {
        return $this->skuId;
    }

    public function setSkuId(int $skuId): self
    {
        $this->skuId = $skuId;

        return $this;
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

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addProduct($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeProduct($this);
        }

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceCurrency(): ?string
    {
        return $this->priceCurrency;
    }

    public function setPriceCurrency(?string $priceCurrency): self
    {
        $this->priceCurrency = $priceCurrency;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getMovie(): ?string
    {
        return $this->movie;
    }

    public function setMovie(?string $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getSourceOrganization(): ?string
    {
        return $this->sourceOrganization;
    }

    public function setSourceOrganization(string $sourceOrganization): self
    {
        $this->sourceOrganization = $sourceOrganization;

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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getVariations(): Collection
    {
        return $this->variations;
    }

    public function addVariation(self $variation): self
    {
        if (!$this->variations->contains($variation)) {
            $this->variations[] = $variation;
            $variation->setParent($this);
        }

        return $this;
    }

    public function removeVariation(self $variation): self
    {
        if ($this->variations->contains($variation)) {
            $this->variations->removeElement($variation);
            // set the owning side to null (unless already changed)
            if ($variation->getParent() === $this) {
                $variation->setParent(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getGroupedProducts(): Collection
    {
        return $this->groupedProducts;
    }

    public function addGroupedProduct(self $groupedProduct): self
    {
        if (!$this->groupedProducts->contains($groupedProduct)) {
            $this->groupedProducts[] = $groupedProduct;
        }

        return $this;
    }

    public function removeGroupedProduct(self $groupedProduct): self
    {
        if ($this->groupedProducts->contains($groupedProduct)) {
            $this->groupedProducts->removeElement($groupedProduct);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSets(): Collection
    {
        return $this->sets;
    }

    public function addSet(self $set): self
    {
        if (!$this->sets->contains($set)) {
            $this->sets[] = $set;
            $set->addGroupedProduct($this);
        }

        return $this;
    }

    public function removeSet(self $set): self
    {
        if ($this->sets->contains($set)) {
            $this->sets->removeElement($set);
            $set->removeGroupedProduct($this);
        }

        return $this;
    }

    public function getCatalogue(): ?Catalogue
    {
        return $this->catalogue;
    }

    public function setCatalogue(?Catalogue $catalogue): self
    {
        $this->catalogue = $catalogue;

        return $this;
    }

    /**
     * @return Collection|Offer[]
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setProduct($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->contains($offer)) {
            $this->offers->removeElement($offer);
            // set the owning side to null (unless already changed)
            if ($offer->getProduct() === $this) {
                $offer->setProduct(null);
            }
        }

        return $this;
    }

    public function getCalendar(): ?string
    {
        return $this->calendar;
    }

    public function setCalendar(?string $calendar): self
    {
        $this->calendar = $calendar;

        return $this;
    }

    public function getRequiresAppointment(): ?bool
    {
        return $this->requiresAppointment;
    }

    public function setRequiresAppointment(bool $requiresAppointment): self
    {
        $this->requiresAppointment = $requiresAppointment;

        return $this;
    }

    public function getDocuments(): ?array
    {
        return $this->documents;
    }

    public function setDocuments(?array $documents): self
    {
        $this->documents = $documents;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getExternalDocs(): ?array
    {
        return $this->externalDocs;
    }

    public function setExternalDocs(?array $externalDocs): self
    {
        $this->externalDocs = $externalDocs;

        return $this;
    }
}
