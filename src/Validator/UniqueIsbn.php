<?php

declare(strict_types=1);

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_CLASS)]
class UniqueIsbn extends Constraint
{
    public string $message = 'This ISBN is already registered in our store.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
