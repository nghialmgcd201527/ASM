<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $full_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $nationality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $gender;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="author_id")
     */
    public $relation;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $image;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

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
            $relation->setAuthorId($this);
        }

        return $this;
    }

    public function removeRelation(Book $relation): self
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getAuthorId() === $this) {
                $relation->setAuthorId(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getFullName();  // or some string field in your Vegetal Entity
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
