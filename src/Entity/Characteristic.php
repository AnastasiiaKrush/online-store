<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharacteristicRepository")
 */
class Characteristic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CategoryCharacteristic", mappedBy="characteristic")
     */
    private $characteristicCategories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductCharacteristic", mappedBy="characteristic")
     */
    private $characteristicProducts;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parent_characteristic_id;

    public function __construct()
    {
        $this->characteristicCategories = new ArrayCollection();
        $this->characteristicProducts = new ArrayCollection();
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

    /**
     * @return Collection|CategoryCharacteristic[]
     */
    public function getCharacteristicCategories(): Collection
    {
        return $this->characteristicCategories;
    }

    public function addCharacteristicCategory(CategoryCharacteristic $characteristicCategory): self
    {
        if (!$this->characteristicCategories->contains($characteristicCategory)) {
            $this->characteristicCategories[] = $characteristicCategory;
            $characteristicCategory->setCharacteristic($this);
        }

        return $this;
    }

    public function removeCharacteristicCategory(CategoryCharacteristic $characteristicCategory): self
    {
        if ($this->characteristicCategories->contains($characteristicCategory)) {
            $this->characteristicCategories->removeElement($characteristicCategory);
            // set the owning side to null (unless already changed)
            if ($characteristicCategory->getCharacteristic() === $this) {
                $characteristicCategory->setCharacteristic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductCharacteristic[]
     */
    public function getCharacteristicProducts(): Collection
    {
        return $this->characteristicProducts;
    }

    public function addCharacteristicProduct(ProductCharacteristic $characteristicProduct): self
    {
        if (!$this->characteristicProducts->contains($characteristicProduct)) {
            $this->characteristicProducts[] = $characteristicProduct;
            $characteristicProduct->setCharacteristic($this);
        }

        return $this;
    }

    public function removeCharacteristicProduct(ProductCharacteristic $characteristicProduct): self
    {
        if ($this->characteristicProducts->contains($characteristicProduct)) {
            $this->characteristicProducts->removeElement($characteristicProduct);
            // set the owning side to null (unless already changed)
            if ($characteristicProduct->getCharacteristic() === $this) {
                $characteristicProduct->setCharacteristic(null);
            }
        }

        return $this;
    }

    public function getParentCharacteristicId(): ?int
    {
        return $this->parent_characteristic_id;
    }

    public function setParentCharacteristicId(?int $parent_characteristic_id): self
    {
        $this->parent_characteristic_id = $parent_characteristic_id;

        return $this;
    }
}
