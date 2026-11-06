<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findById(UuidInterface $id): ?Author
    {
        return $this->findOneBy([
            'uuid' => $id,
        ]);
    }

    public function findAll(): array
    {
        return $this->findBy([], [
            'uuid' => 'ASC',
        ]);
    }
}
