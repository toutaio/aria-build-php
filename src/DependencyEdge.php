<?php

declare(strict_types=1);

namespace Touta\Aria\Build;

final readonly class DependencyEdge
{
    public function __construct(
        public ComponentName $fromComponent,
        public ComponentName $toComponent,
    ) {}
}
