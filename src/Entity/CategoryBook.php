<?php

namespace App\Entity;

use App\Repository\CategoryBookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryBookRepository::class)
 */
class CategoryBook
{
    protected $books;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $category_name;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="category_id")
     */
    private $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Book $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation[] = $relation;
            $relation->setCategoryId($this);
        }

        return $this;
    }

    public function removeRelation(Book $relation): self
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getCategoryId() === $this) {
                $relation->setCategoryId(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getCategoryName();  // or some string field in your Vegetal Entity
    }
}
