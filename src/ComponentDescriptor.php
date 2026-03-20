<?php

declare(strict_types=1);

namespace Touta\Aria\Build;

final readonly class ComponentDescriptor
{
    /**
     * @param list<string> $dependencies
     */
    public function __construct(
        public string $name,
        public Layer $layer,
        public array $dependencies = [],
    ) {}
}
