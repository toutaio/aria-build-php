<?php

declare(strict_types=1);

namespace Touta\Aria\Build;

final readonly class ComponentDescriptor
{
    /**
     * @param list<ComponentName> $dependencies
     */
    public function __construct(
        public ComponentName $name,
        public Layer $layer,
        public array $dependencies = [],
    ) {}
}
