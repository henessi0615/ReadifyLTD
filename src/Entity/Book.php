<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: 'books')]
class Book
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidInterface $uuid;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'string', length: 13, unique: true)]
    private string $isbn;

    #[ORM\Column(name: 'price_amount', type: 'string', length: 8)]
    private string $priceAmount;

    #[ORM\Column(name: 'price_currency', type: 'string', length: 3)]
    private string $priceCurrency;

    /**
     * @var Collection<int, Author>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    #[ORM\JoinTable(name: 'books_authors')]
    #[ORM\JoinColumn(name: 'book_id', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'author_id', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    private Collection $authors;

    /**
     * @param array<int, Author> $authors
     */
    public function __construct(
        string $title,
        string $description,
        string $isbn,
        Money $price,
        array $authors
    ) {
        $this->uuid = Uuid::uuid7();
        $this->title = $title;
        $this->description = $description;
        $this->isbn = $isbn;
        $this->setPrice($price);
        $this->authors = new ArrayCollection();

        /** @var Author $author */
        foreach ($authors as $author) {
            $this->addAuthor($author);
        }
    }

    public function getId(): UuidInterface
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): void
    {
        $this->isbn = $isbn;
    }

    public function getPrice(): Money
    {
        return new Money((int) $this->priceAmount, new Currency($this->priceCurrency));
    }

    public function setPrice(Money $price): self
    {
        $this->priceAmount = $price->getAmount();
        $this->priceCurrency = $price->getCurrency()->getCode();

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): self
    {
        if (! $this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addBook($this);
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        if ($this->authors->removeElement($author)) {
            $author->removeBook($this);
        }

        return $this;
    }
}
