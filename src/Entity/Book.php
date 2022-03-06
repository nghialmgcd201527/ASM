<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
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
    public $book_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $description;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryBook::class, inversedBy="relation")
     * @ORM\JoinColumn(nullable=false)
     */
    public $category_id;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="relation")
     * @ORM\JoinColumn(nullable=false)
     */
    public $author_id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    public $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookName(): ?string
    {
        return $this->book_name;
    }

    public function setBookName(string $book_name): self
    {
        $this->book_name = $book_name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategoryId(): ?CategoryBook
    {
        return $this->category_id;
    }

    public function setCategoryId(?CategoryBook $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getAuthorId(): ?Author
    {
        return $this->author_id;
    }

    public function setAuthorId(?Author $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
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
