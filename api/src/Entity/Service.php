<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
	/**
	 * @var \Ramsey\Uuid\UuidInterface
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
	 * @Groups({"read"})
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
	 */
	private $id;

    /**
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups({"read","write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    
    /**
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     */
    private $organisation;

    /**
     * @Groups({"read","write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="parent")
     */
    private $children;

    /**
     * @Groups({"write"})
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="children")
     */
    private $parent;

    /**
     * @Groups({"write"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", mappedBy="Services")
     */
    private $groups;

    /**
     * @Groups({"read","write"})
     * @ORM\Column(type="money")
     */
    private $price;

    public function __construct()
    {
        $this->parent = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function getId()
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
    
    public function getOrganisation(): ?string
    {
    	return $this->organisation;
    }
    
    public function setOrganisation(string $organisation): self
    {
    	$this->organisation = $organisation;
    	
    	return $this;
    }

    public function getChildren(): ?self
    {
        return $this->children;
    }

    public function setChildren(?self $children): self
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parent->contains($parent)) {
            $this->parent[] = $parent;
            $parent->setChildren($this);
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        if ($this->parent->contains($parent)) {
            $this->parent->removeElement($parent);
            // set the owning side to null (unless already changed)
            if ($parent->getChildren() === $this) {
                $parent->setChildren(null);
            }
        }

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
            $group->addService($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeService($this);
        }

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }
}
