<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(type="string", length=255)
     */
    private $description_short;

    /**
     * @ORM\Column(type="text")
     */
    private $description_full;

    /**
     * @ORM\Column(type="float")
     */
    private $price_old;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price_new;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductImages", mappedBy="product")
     */
    private $productImages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductCategory", mappedBy="product")
     */
    private $productCategories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductCharacteristic", mappedBy="product")
     */
    private $productCharacteristics;

    public function __construct()
    {
        $this->productImages = new ArrayCollection();
        $this->productCategories = new ArrayCollection();
        $this->productCharacteristics = new ArrayCollection();
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

    public function getDescriptionShort(): ?string
    {
        return $this->description_short;
    }

    public function setDescriptionShort(string $description_short): self
    {
        $this->description_short = $description_short;

        return $this;
    }

    public function getDescriptionFull(): ?string
    {
        return $this->description_full;
    }

    public function setDescriptionFull(string $description_full): self
    {
        $this->description_full = $description_full;

        return $this;
    }

    public function getPriceOld(): ?float
    {
        return $this->price_old;
    }

    public function setPriceOld(float $price_old): self
    {
        $this->price_old = $price_old;

        return $this;
    }

    public function getPriceNew(): ?float
    {
        return $this->price_new;
    }

    public function setPriceNew(?float $price_new): self
    {
        $this->price_new = $price_new;

        return $this;
    }

    /**
     * @return Collection|ProductImages[]
     */
    public function getProductImages(): Collection
    {
        return $this->productImages;
    }

    public function addProductImage(ProductImages $productImage): self
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages[] = $productImage;
            $productImage->setProduct($this);
        }

        return $this;
    }

    public function removeProductImage(ProductImages $productImage): self
    {
        if ($this->productImages->contains($productImage)) {
            $this->productImages->removeElement($productImage);
            // set the owning side to null (unless already changed)
            if ($productImage->getProduct() === $this) {
                $productImage->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductCategory[]
     */
    public function getProductCategories(): Collection
    {
        return $this->productCategories;
    }

    public function addProductCategory(ProductCategory $productCategory): self
    {
        if (!$this->productCategories->contains($productCategory)) {
            $this->productCategories[] = $productCategory;
            $productCategory->setProduct($this);
        }

        return $this;
    }

    public function removeProductCategory(ProductCategory $productCategory): self
    {
        if ($this->productCategories->contains($productCategory)) {
            $this->productCategories->removeElement($productCategory);
            // set the owning side to null (unless already changed)
            if ($productCategory->getProduct() === $this) {
                $productCategory->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductCharacteristic[]
     */
    public function getProductCharacteristics(): Collection
    {
        return $this->productCharacteristics;
    }

    public function addProductCharacteristic(ProductCharacteristic $productCharacteristic): self
    {
        if (!$this->productCharacteristics->contains($productCharacteristic)) {
            $this->productCharacteristics[] = $productCharacteristic;
            $productCharacteristic->setProduct($this);
        }

        return $this;
    }

    public function removeProductCharacteristic(ProductCharacteristic $productCharacteristic): self
    {
        if ($this->productCharacteristics->contains($productCharacteristic)) {
            $this->productCharacteristics->removeElement($productCharacteristic);
            // set the owning side to null (unless already changed)
            if ($productCharacteristic->getProduct() === $this) {
                $productCharacteristic->setProduct(null);
            }
        }

        return $this;
    }
}
