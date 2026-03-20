<?php

declare(strict_types=1);

namespace Touta\Aria\Build;

final readonly class ComponentName
{
    private function __construct(
        public string $value,
    ) {}

    public static function from(string $value): self
    {
        return new self($value);
    }
}
