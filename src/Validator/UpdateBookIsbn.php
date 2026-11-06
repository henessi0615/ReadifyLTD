<?php

declare(strict_types=1);

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @Target({"CLASS", "ANNOTATION"})
 */
#[Attribute(Attribute::TARGET_CLASS)]
class UpdateBookIsbn extends Constraint
{
    public string $message = 'The ISBN "{{ isbn }}" is already taken by another book.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
