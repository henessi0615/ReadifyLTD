<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\AuthorRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class AuthorExistsValidator extends ConstraintValidator
{
    public function __construct(
        private readonly AuthorRepository $authorRepository
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (! $constraint instanceof AuthorExists) {
            throw new UnexpectedTypeException($constraint, AuthorExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $authorIds = is_array($value) ? $value : [$value];

        foreach ($authorIds as $authorId) {
            if (! is_string($authorId)) {
                $this->context->buildViolation('The author ID must be a string.')
                    ->addViolation()
                ;
                continue;
            }

            $author = $this->authorRepository->findById(Uuid::fromString($authorId));

            if (null === $author) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $authorId)
                    ->addViolation()
                ;
            }
        }
    }
}
