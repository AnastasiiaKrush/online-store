<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * * @UniqueEntity(
 *     fields="name",
 *     errorPath="name",
 *     message="Такая категория уже существует."
 * )
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductCategory", mappedBy="category")
     */
    private $categoryProducts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CategoryCharacteristic", mappedBy="category")
     */
    private $categoryCharacteristics;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parent_category_id;

    public function __construct()
    {
        $this->categoryProducts = new ArrayCollection();
        $this->categoryCharacteristics = new ArrayCollection();
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
     * @return Collection|ProductCategory[]
     */
    public function getCategoryProducts(): Collection
    {
        return $this->categoryProducts;
    }

    public function addCategoryProduct(ProductCategory $categoryProduct): self
    {
        if (!$this->categoryProducts->contains($categoryProduct)) {
            $this->categoryProducts[] = $categoryProduct;
            $categoryProduct->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryProduct(ProductCategory $categoryProduct): self
    {
        if ($this->categoryProducts->contains($categoryProduct)) {
            $this->categoryProducts->removeElement($categoryProduct);
            // set the owning side to null (unless already changed)
            if ($categoryProduct->getCategory() === $this) {
                $categoryProduct->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CategoryCharacteristic[]
     */
    public function getCategoryCharacteristics(): Collection
    {
        return $this->categoryCharacteristics;
    }

    public function addCategoryCharacteristic(CategoryCharacteristic $categoryCharacteristic): self
    {
        if (!$this->categoryCharacteristics->contains($categoryCharacteristic)) {
            $this->categoryCharacteristics[] = $categoryCharacteristic;
            $categoryCharacteristic->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryCharacteristic(CategoryCharacteristic $categoryCharacteristic): self
    {
        if ($this->categoryCharacteristics->contains($categoryCharacteristic)) {
            $this->categoryCharacteristics->removeElement($categoryCharacteristic);
            // set the owning side to null (unless already changed)
            if ($categoryCharacteristic->getCategory() === $this) {
                $categoryCharacteristic->setCategory(null);
            }
        }

        return $this;
    }

    public function getParentCategoryId(): ?int
    {
        return $this->parent_category_id;
    }

    public function setParentCategoryId(?int $parent_category_id): self
    {
        $this->parent_category_id = $parent_category_id;

        return $this;
    }
}
