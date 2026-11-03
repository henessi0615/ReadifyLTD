<?php

declare(strict_types=1);

namespace App\Request;

use OpenApi\Spec\Schema;
use Symfony\Component\Validator\Constraints as Assert;

#[Schema(title: 'CreateAuthorRequest')]
final readonly class CreateAuthorRequest
{
    public function __construct(
        #[Assert\Sequentially([
            new Assert\NotBlank(message: 'Author name cannot be blank.'),
            new Assert\Length(max: 24, maxMessage: 'Author name cannot exceed {{ limit }} characters.'),
        ])]
        public string $name,
        #[Assert\Sequentially([
            new Assert\NotBlank(message: 'Author biography cannot be blank.'),
            new Assert\Length(max: 2000, maxMessage: 'Author biography cannot exceed {{ limit }} characters.'),
        ])]
        public ?string $biography
    ) {
    }
}
